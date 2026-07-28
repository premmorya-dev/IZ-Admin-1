<?php

namespace App\Services\Invoice;

use App\Models\InvoiceModel;
use Illuminate\Support\Str;

class InvoiceShareService
{
    public function generatePublicLink(InvoiceModel $invoice): string
    {
        if (!$invoice->share_token) {

            do {
                $token = Str::random(6);
            } while (
                InvoiceModel::where('share_token', $token)->exists()
            );

            $invoice->share_token = $token;
        }

        $invoice->public_link_expires_at = now()->addDays(7);

        $invoice->save();

        return route('download.invoice.securelink', [
            'token' => $invoice->share_token
        ]);
    }

    public function isExpired(InvoiceModel $invoice): bool
    {
        return $invoice->public_link_expires_at &&
            $invoice->public_link_expires_at->isPast();
    }

    public function sendWhatsAppInvoice(InvoiceModel $invoice)
    {
        $shortcode = getShortcode('invoice', $invoice->invoice_code, $invoice->user_id);
        $data = [
            'client_name'     => $shortcode['{{client_name}}'],
            'company_name'    => $shortcode['{{user_company_name}}'],
            'invoice_number'  => $shortcode['{{invoice_number}}'],
            'invoice_date'    => $shortcode['{{invoice_date}}'],
            'due_date'        => $shortcode['{{invoice_due_date}}'],
            'amount'          => $shortcode['{{invoice_grand_total}}'],
            'total_due'       => $shortcode['{{invoice_total_due}}'],
            'invoice_currency_symbol'       => $shortcode['{{invoice_currency_symbol}}'],
            'status'          => $invoice->status === 'paid' ? 'Paid' : 'Pending',
            'invoice_url'     => route('download.invoice.securelink', $invoice->share_token),
            'user_company_name' => $shortcode['{{user_company_name}}'],
            'user_address_1' => $shortcode['{{user_address_1}}'],
            'user_state' => $shortcode['{{user_state}}'],
            'user_country' => $shortcode['{{user_country}}'],
            'user_pincode' => $shortcode['{{user_pincode}}']
        ];

        // number ke saath (client ka WhatsApp no. DB se, format: 919876543210 — bina '+', bina space)
        $whatsappLink = $this->buildLink($data, '91' . $shortcode['{{client_phone}}']);

        return redirect($whatsappLink);
    }

    public function buildMessage(array $data): string
    {
        $divider = str_repeat('─', 22);

        $message = "*INVOICE READY*\n";
        $message .= "{$divider}\n";
        $message .= "Hi {$data['client_name']},\n\n";
        $message .= "Thank you for choosing *{$data['company_name']}*. Your invoice has been generated and is ready for download.\n\n";
        $message .= "{$divider}\n";
        $message .= "```\n";
        $message .= "Invoice No.      {$data['invoice_number']}\n";
        $message .= "Invoice Date     {$data['invoice_date']}\n";
        $message .= "Due Date         {$data['due_date']}\n";
        $message .= "Amount           {$data['invoice_currency_symbol']}{$data['amount']}\n";
        $message .= "Due              {$data['invoice_currency_symbol']}{$data['total_due']}\n";
        $message .= "Status           {$data['status']}\n";
        $message .= "```\n";
        $message .= "{$divider}\n\n";
        $message .= "*Download Invoice (PDF)*\n";
        $message .= "{$data['invoice_url']}\n\n";
        $message .= "{$divider}\n\n";
        $message .= "If you've already completed the payment, please disregard this message.\n";
        $message .= "For any questions regarding this invoice, simply reply to this chat.\n";
        $message .= "Thank you for your business.\n\n";
        $message .= "{$divider}\n";
        $message .= "*{$data['user_company_name']}*\n";
        $message .= "{$data['user_address_1']}\n";
        $message .= "{$data['user_state']} {$data['user_country']} {$data['user_pincode']}\n";
        $message .= "\n";

        return $message;
    }

    /**
     * Build the wa.me link.
     *
     * @param string|null $phone Client's WhatsApp number in E.164 format
     *                           without '+' (e.g. 919876543210). Pass null
     *                           to open WhatsApp's contact picker instead.
     */
    public function buildLink(array $data, ?string $phone = null): string
    {
        $text = rawurlencode($this->buildMessage($data));

        return $phone
            ? "https://wa.me/{$phone}?text={$text}"
            : "https://wa.me/?text={$text}";
    }
}
