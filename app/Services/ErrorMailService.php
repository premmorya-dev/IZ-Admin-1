<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class ErrorMailService
{
    public function send($subject, $body)
    {
        $mail = new PHPMailer(true);

        try {

            $smtp = DB::table('smtp_settings')->first();

            if (!$smtp) {
                return;
            }

            $mail->isSMTP();
            $mail->Host = $smtp->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $smtp->smtp_username;
            $mail->Password = $smtp->smtp_password;
            $mail->Port = $smtp->smtp_port;

            $mail->SMTPSecure = $smtp->smtp_encryption == 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;

            $mail->SMTPDebug = $smtp->smtp_debug;

            $mail->CharSet = "UTF-8";

            $mail->setFrom(
                config('mail.error_report_email'),
                'Invoicezy'
            );

            $mail->addAddress(config('mail.error_report_email'));

            $mail->isHTML(true);

            $mail->Subject = $subject;

            $mail->Body = $body;

            $mail->send();

        } catch (Exception $e) {

            \Log::error($mail->ErrorInfo);

        }
    }
}