<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PHPMailer\PHPMailer\Exception as PHPMailerException;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\DB;

class EmailService
{
    /**
     * Send an HTML email rendered from a Blade view.
     *
     * @param  string  $to
     * @param  string  $toName
     * @param  string  $subject
     * @param  string  $view       Blade view name, e.g. 'emails.welcome'
     * @param  array   $data       Variables passed to the view
     * @param  array   $attachments  [['path' => ..., 'name' => ...], ...]
     * @param  string|null  $replyTo
     * @param  array   $cc
     * @param  array   $bcc
     *
     * @throws PHPMailerException
     */
    public function send(
        string $to,
        string $toName,
        string $subject,
        string $view,
        array $data = [],
        array $attachments = [],
        ?string $replyTo = null,
        array $cc = [],
        array $bcc = [],
    ): bool {
        $mailer = $this->buildMailer();

        try {
            $mailer->addAddress($to, $toName);

            if ($replyTo) {
                $mailer->addReplyTo($replyTo);
            }

            foreach ($cc as $ccAddress) {
                $mailer->addCC($ccAddress);
            }

            foreach ($bcc as $bccAddress) {
                $mailer->addBCC($bccAddress);
            }

            foreach ($attachments as $attachment) {
                $mailer->addAttachment($attachment['path'], $attachment['name'] ?? '');
            }

            $mailer->isHTML(true);
            $mailer->Subject = $subject;
            $mailer->Body    = view($view, $data)->render();
            $mailer->AltBody = strip_tags($mailer->Body);

            $mailer->send();

            return true;
        } catch (PHPMailerException $e) {
            Log::error('EmailService: send failed', [
                'to'    => $to,
                'view'  => $view,
                'error' => $mailer->ErrorInfo ?: $e->getMessage(),
            ]);

            throw $e;
        }
    }

    /**
     * Build a fully configured PHPMailer instance.
     * This is the ONLY place SMTP configuration lives.
     */
    protected function buildMailer(): PHPMailer
    {
        $mailer = new PHPMailer(true);

        $smtp = DB::table('smtp_settings')->first();

       

        $mailer->isSMTP();
        $mailer->Host       = $smtp->smtp_host;
        $mailer->SMTPAuth   = true;
        $mailer->Username   =$smtp->smtp_username;
        $mailer->Password   = $smtp->smtp_password;
        $mailer->SMTPSecure = $smtp->smtp_encryption == 'ssl'
                ? PHPMailer::ENCRYPTION_SMTPS
                : PHPMailer::ENCRYPTION_STARTTLS;
        $mailer->Port       = $smtp->smtp_port;

        $mailer->setFrom(
            config('mail.error_report_email'),
           'InvoiceZy'
        );

        $mailer->CharSet = 'UTF-8';

        return $mailer;
    }
}
