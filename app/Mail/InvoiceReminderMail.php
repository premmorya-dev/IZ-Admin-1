<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
class InvoiceReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;
    public $type;

    public function __construct($invoice, $type)
    {
        $this->invoice = $invoice;
        $this->type = $type;
    }

    public function build()
    {

      
        return $this->subject('Invoice Payment Reminder')
                    ->view('emails.invoice_reminder');
    }
}
