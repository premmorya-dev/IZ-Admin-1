<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailerService
{
    public function sendEmail($to, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // SMTP Settings
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host       = env('SMTP_HOST');
            $mail->SMTPAuth   = true;
            $mail->Username   = env('SMTP_USERNAME');
            $mail->Password   = env('SMTP_PASSWORD');
            $mail->SMTPSecure = env('SMTP_ENCRYPTION');
            $mail->Port       = env('SMTP_PORT', 587);
            $mail->SMTPAutoTLS = true;
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            // Allow self-signed certificates
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ];

            // From
            $mail->setFrom(env('SMTP_FROM_EMAIL'), env('SMTP_FROM_NAME', 'InvoiceZy'));

            // To
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            // Send
            $mail->send();
            return true;

        } catch (Exception $e) {
            throw new \Exception($mail->ErrorInfo);
        }
    }
}
