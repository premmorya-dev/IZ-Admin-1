<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceReminderMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class SendInvoiceRemindersBeforeDueDate extends Command
{
    protected $signature = 'app:send-invoice-reminders-before-due-date {--user_id=0} {--limit=0}';
    protected $description = 'Send invoice reminders before due date using query builder';

    public function handle()
    {

        $user_id = $this->option('user_id');
        $limit = $this->option('limit');


        $today = Carbon::today('UTC');

        if ($user_id != 0) {
            $query = DB::table('users as u')
                ->join('settings as s', 's.user_id', '=', 'u.user_id')
                ->where('s.invoice_payment_reminder_status', '=', 'Y')
                ->whereNotNull('s.reminder_before_due_days')
                ->where('u.user_id', $user_id)
                ->select('u.user_id', 's.*');
        } else {
            $query = DB::table('users as u')
                ->join('settings as s', 's.user_id', '=', 'u.user_id')
                ->where('s.invoice_payment_reminder_status', '=', 'Y')
                ->whereNotNull('s.reminder_before_due_days')
                ->select('u.user_id', 's.*');
        }




        $query->when($limit != 0, function ($query) {
            return $query->limit($this->option('limit'));
        });

        $users =  $query->get();




        if (!empty($users)) {


            foreach ($users as $user) {


                $twoDaysFromNow = $today->copy()->addDays($user->reminder_before_due_days)->format('Y-m-d');
                // 1. Reminder: Due in 2 days
                $dueSoon = DB::table('users as u')
                    ->join('invoices as i', 'i.user_id', '=', 'u.user_id')
                    ->join('clients as c', 'i.client_id', '=', 'c.client_id')
                    ->join('settings as s', 's.user_id', '=', 'u.user_id')
                    ->whereDate('i.due_date', '=',  $twoDaysFromNow) // safer with date-only comparison
                    ->where('i.is_paid', '=', 'N')
                    ->where('i.is_cancelled', '=', 'N')
                    ->where('u.user_id', '=', $user->user_id)
                    ->select(
                        'i.*',
                        'c.client_name',
                        'c.email',
                        'u.first_name',
                        'u.last_name',
                        's.company_name'
                    )
                    ->get();


                $smtp_data =  DB::table('smtp_settings')
                    ->where('smtp_id', 1)
                    ->first();

                $email_templates_config =  DB::table('email_templates')
                    ->where('email_template_id', 1)
                    ->first();

                foreach ($dueSoon as $invoice) {

                    if (!empty($invoice->email)) {


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
                            // $mail->setFrom($email_templates_config->email_template_from_email, $email_templates_config->email_template_from_name);

                            $mail->setFrom($email_templates_config->email_template_from_email, $user->company_name ?? $user->first_name);
                            $mail->addAddress($invoice->email, $invoice->client_name); // Add a recipient



                            $mail->isHTML(true); // Set email format to HTML
                            $mail->Subject =  'Invoice Payment Reminder';
                            $mail->Body    =  view('emails.invoice_reminder_before_due_date', compact('invoice'));

                            $mail->SMTPOptions = [
                                'ssl' => [
                                    'verify_peer' => false,
                                    'verify_peer_name' => false,
                                    'allow_self_signed' => true,
                                ],
                            ];

                            $mail->send();
                            // DB::table('invoices')->where([
                            //     'user_id' => $notification->user_id,
                            //     'invoice_id' => $invoice_data->invoice_id,
                            // ])->update([
                            //     'is_sent' => 'sent',
                            //     'sent_at' =>  Carbon::now('UTC')->format('Y-m-d H:i:s')
                            // ]);
                        } catch (Exception $e) {
                         
                            Log::error('send invoice reminder before due date Error: ' . $e->getMessage());
                        }
                    }
                }
            }
        }

        $this->info('Invoice reminders sent before due date using Query Builder.');
    }
}
