<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\InvoiceModel;
use App\Models\NotificationModel;
use App\Models\User;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SendInvoiceEmails extends Command
{
  protected $signature = 'invoices:send-emails  {--notification_id=0} {--limit=0}';
  protected $description = 'Send queued invoice emails to clients';

  public function handle()
  {

    $error = '';
    $log = '';


    $notification_id = $this->option('notification_id');
    $limit = $this->option('limit');




    if ($notification_id != 0) {
      $query = DB::table('notifications')
        ->where('notification_type', 'email')
        ->where('notification_id', $notification_id)
        ->whereIn('processing_status', ['pending', 'submitted'])
        ->orderBy('notification_id', 'asc');
    } else {
      $query = DB::table('notifications')
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

        $notification_queue = NotificationModel::findOrFail($notification->notification_id);

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
    $notification_queue = NotificationModel::findOrFail($notification->notification_id);
    $notification_queue->processing_status = 'running';
    $notification_queue->cron_start_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
    $notification_queue->save();


    $invoice_data = DB::table('invoices')
      ->select(
        'invoices.*',
        'settings.*',
        'clients.*',
        'clients.email as client_email',

      )
      ->leftJoin('settings', 'settings.user_id', 'invoices.user_id')
      ->leftJoin('clients', 'clients.client_id', 'invoices.client_id')
      ->where('invoices.invoice_id', $notification->invoice_id)
      ->where('invoices.user_id', $notification->user_id)
      ->first();




    //   dd($registration_data['registration_id']); 
    $smtp_data =  DB::table('smtp_settings')
      ->where('smtp_id', 1)
      ->first();

    $email_templates_config =  DB::table('email_templates')
      ->where('email_template_id', 1)
      ->first();

    $email_templates_data =  DB::table('templates')
      ->where('template_id', $invoice_data->template_id)
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
      $mail->setFrom($email_templates_config->email_template_from_email, $email_templates_config->email_template_from_name);
      $mail->addAddress($invoice_data->client_email, $invoice_data->client_name); // Add a recipient


      // Attachments (optional)
      // $mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments
      // $mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

      // Content
      $invoice_html =  shortcode("invoice", $invoice_data->invoice_code, $email_templates_data->content, $invoice_data->user_id);

      $pdf = Pdf::loadHTML($invoice_html)
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
      $pdfPath = $tempFolder . '/invoice_' . $invoice_data->invoice_number . '.pdf';

      // Save PDF
      $pdf->save($pdfPath);
      // Attach PDF
      $mail->addAttachment($pdfPath, 'Invoice_' . $invoice_data->invoice_number . '.pdf');

      $subject = shortcode("invoice", $invoice_data->invoice_code, $email_templates_data->email_template_subject, $invoice_data->user_id);
      $message = shortcode("invoice", $invoice_data->invoice_code, $email_templates_config->email_template_html, $invoice_data->user_id);


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


      $log =  "\Notification id: {$notification->notification_id} | User Id: {$notification->user_id} | Type: {$notification->notification_type} | Email: {$invoice_data->client_email}  | Status: Email sent successfully";
      echo $log;




      $notification_queue = NotificationModel::findOrFail($notification->notification_id);
      $notification_queue->processing_status = 'success';
      $notification_queue->content = $message;
      $notification_queue->cron_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->processing_log = $log;
      $notification_queue->save();

      DB::table('invoices')->where([
        'user_id' => $notification->user_id,
        'invoice_id' => $invoice_data->invoice_id,
      ])->update([
        'is_sent' => 'sent',
        'sent_at' =>  Carbon::now('UTC')->format('Y-m-d H:i:s')
      ]);
    } catch (Exception $e) {



      $log =  "\Notification id: {$notification->notification_id} | User Id: {$notification->user_id} | Type: {$notification->notification_type} | Email: {$invoice_data->client_email}  | Status: Email sent unsuccessfully | Error: {$mail->ErrorInfo}";


      echo $log;

      $notification_queue = NotificationModel::findOrFail($notification->notification_id);
      $notification_queue->processing_status = 'failed';
      $notification_queue->cron_end_datetime = Carbon::now('UTC')->format('Y-m-d H:i:s');
      $notification_queue->processing_log = $log;
      $notification_queue->save();
    }
  }
}
