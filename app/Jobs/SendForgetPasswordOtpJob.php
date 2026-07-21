<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SendForgetPasswordOtpJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $email;
    public $otp;
    public function __construct($email, $otp)
    {
        $this->email = $email;
        $this->otp = $otp;
    }
   

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $mail = new PHPMailer(true);
        $smtp_data = DB::table('smtp_settings')->where('smtp_id', 1)->first();
        $email_template = DB::table('email_templates')->where('email_template_id', 2)->first();

        $user = User::select('first_name', 'last_name')
            ->where('email', $this->email)
            ->firstOrFail();

        $name = $user->first_name . ' ' . $user->last_name;


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

        // from
        $mail->setFrom($email_template->email_template_from_email, 'InvoiceZy');

        //to
        $mail->addAddress($this->email); // 

        // Content

        $message =   str_replace('{{OTP}}', $this->otp, $email_template->email_template_html);
        $message =   str_replace('{{NAME}}', $name,  $message);
        $message =   str_replace('{{LOGO}}', asset('logo.png'), $message);

        $subject =   $email_template->email_template_subject;

        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject =  $subject;
        $mail->Body    =  $message;
        $mail->send();


    }
}
