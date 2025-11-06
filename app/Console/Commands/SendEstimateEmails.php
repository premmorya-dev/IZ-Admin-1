<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\EstimateModel;
use App\Models\EstimateNotificationModel;
use App\Models\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SendEstimateEmails extends Command
{
  protected $signature = 'send-estimate-email  {--notification_id=0}  {--limit=0}';
  protected $description = 'Send Estimate emails to clients';

  public function handle()
  {

    $error = '';
    $log = '';


    $notification_id = $this->option('notification_id');
    $limit = $this->option('limit');


    if ($notification_id != 0) {
      $query = DB::table('estimate_notifications')
        ->where('notification_type', 'email')
        ->where('notification_id', $notification_id)
        ->whereIn('processing_status', ['pending', 'submitted'])
        ->orderBy('notification_id', 'asc');
    } else {
      $query = DB::table('estimate_notifications')
        ->where('notification_type', 'email')
        ->whereIn('processing_status', ['pending', 'submitted'])
        ->orderBy('notification_id', 'asc');
    }




    $query->when($limit != 0, function ($query) {
      return $query->limit($this->option('limit'));
    });

    $notifications = $query->get();



    if ($notifications->isEmpty()) {
      $log = "\nNotification queue is empty\n";
      echo $log;
    }


    if (!empty($notifications)) {

      foreach ($notifications  as $notification) {

        $notification_queue = EstimateNotificationModel::findOrFail($notification->notification_id);

        if ($notification->processing_status  == 'running') {
          $log =  "\Notification id: {$notification->notification_id} | User Id: {$notification->user_id} | Type: {$notification->usnotification_typer_id} | Status: {$notification->processing_status}  | Status: Email sent unsuccessfully | Msg: notification is already running";
          echo $log;
          continue;
        } else  if ($notification->processing_status  == 'success') {
          $log =  "\Notification id: {$notification->notification_id} | User Id: {$notification->user_id} | Type: {$notification->usnotification_typer_id} | Status: {$notification->processing_status} | Status: Email sent unsuccessfully | Msg: notification is already completed";
          echo $log;
          continue;
        }
        $this->sendEmail($notification);
      }
    }



    //  return Command::SUCCESS;
  }






  public function sendEmail($notification)
  {
    $notification_queue = EstimateNotificationModel::findOrFail($notification->notification_id);
    $notification_queue->processing_status = 'running';
    $notification_queue->cron_start_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
    $notification_queue->save();


    $estimate_data = DB::table('estimates')
      ->select(
        'estimates.*',
        'settings.*',
        'clients.*',
        'clients.email as client_email',
        'estimates.template_id as template_id',
        'users.first_name',
        'users.last_name',

      )
      ->leftJoin('settings', 'settings.user_id', 'estimates.user_id')
      ->leftJoin('clients', 'clients.client_id', 'estimates.client_id')
      ->leftJoin('users', 'users.user_id', 'estimates.user_id')
      ->where('estimates.estimate_id', $notification->estimate_id)
      ->where('estimates.user_id', $notification->user_id)
      ->first();






    //   dd($registration_data['registration_id']); 
    $smtp_data =  DB::table('smtp_settings')
      ->where('smtp_id', 1)
      ->first();

    $email_templates_config =  DB::table('email_templates')
      ->where('email_template_id', 1)
      ->first();

    $email_templates_data =  DB::table('estimate_templates')
      ->where('template_id', $estimate_data->template_id)
      ->first();




    $mail = new PHPMailer(true);

    try {
      // Server settings
      $mail->CharSet = 'UTF-8';           // ✅ Fix encoding
      $mail->Encoding = 'base64';
      $mail->SMTPDebug =  $smtp_data->smtp_debug; // Enable verbose debug output
      $mail->isSMTP(); // Set mailer to use SMTP
      $mail->Host       = $smtp_data->smtp_host; // Specify main and backup SMTP servers
      $mail->SMTPAuth   = true; // Enable SMTP authentication
      $mail->Username   = $smtp_data->smtp_username; // SMTP username
      $mail->Password   = $smtp_data->smtp_password; // SMTP password
      $mail->SMTPSecure = $smtp_data->smtp_encryption; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
      $mail->Port       = $smtp_data->smtp_port;; // TCP port to connect to

      // Recipients
      $mail->setFrom($email_templates_config->email_template_from_email,  $estimate_data->company_name ?? $estimate_data->first_name . " " . $estimate_data->last_name);
      $mail->addAddress($estimate_data->client_email, $estimate_data->client_name); // Add a recipient


      // Attachments (optional)
      // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

      // Content
      $estimate_html =  shortcode('estimate', $estimate_data->estimate_code, $email_templates_data->content, $estimate_data->user_id);

      $pdf = Pdf::loadHTML($estimate_html)
        ->setPaper('a4', 'portrait')
        ->setWarnings(false)
        ->setOptions([
          'isHtml5ParserEnabled' => true,
          'isRemoteEnabled' => true, // allows external CSS/images
        ]);
      // Define temp folder path
      $tempFolder = storage_path('app/temp');

      // Ensure temp folder exists and has correct permissions
      if (!is_dir($tempFolder)) {
        mkdir($tempFolder, 0775, true);
        chmod($tempFolder, 0775);
      }
      // Define PDF path
      $pdfPath = $tempFolder . '/estimate_' . $estimate_data->estimate_number . '.pdf';

      // Save PDF
      $pdf->save($pdfPath);
      // Attach PDF
      $mail->addAttachment($pdfPath, 'estimate_' . $estimate_data->estimate_number . '.pdf');


      $subject = shortcode('estimate', $estimate_data->estimate_code, $email_templates_data->email_template_subject, $estimate_data->user_id);
      $message = shortcode('estimate', $estimate_data->estimate_code, $email_templates_config->estimate_email_message_template, $estimate_data->user_id);

      //$message = appendUTM($message, $email_templates_data['email_template_link_utm']);

      $mail->isHTML(true); // Set email format to HTML
      $mail->Subject =  $subject;
      $mail->Body    =  $message;

      $mail->SMTPOptions = [
        'ssl' => [
          'verify_peer' => false,
          'verify_peer_name' => false,
          'allow_self_signed' => true,
        ],
      ];





      if ($mail->send()) {
        if (file_exists($pdfPath)) {
          unlink($pdfPath);
        }
      }


      $log =  "\Notification id: {$notification->notification_id} | User Id: {$notification->user_id} | Type: {$notification->notification_type} | Email: {$estimate_data->client_email}  | Status: Email sent successfully";
      echo $log;




      $notification_queue = EstimateNotificationModel::findOrFail($notification->notification_id);
      $notification_queue->processing_status = 'success';
      $notification_queue->content = $message;
      $notification_queue->cron_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->processing_log = $log;
      $notification_queue->save();

      DB::table('estimates')->where([
        'user_id' => $notification->user_id,
        'estimate_id' => $estimate_data->estimate_id,
      ])->update([
        'is_sent' => 'sent',
        'sent_at' =>  Carbon::now('UTC')->format('Y-m-d H:i:s')
      ]);
    } catch (Exception $e) {



      $log =  "\Notification id: {$notification->notification_id} | User Id: {$notification->user_id} | Type: {$notification->notification_type} | Email: {$estimate_data->client_email}  | Status: Email sent unsuccessfully | Error: {$mail->ErrorInfo}";


      echo $log;

      $notification_queue = EstimateNotificationModel::findOrFail($notification->notification_id);
      $notification_queue->processing_status = 'failed';
      $notification_queue->cron_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->processing_log = $log;
      $notification_queue->save();
    }
  }
}
