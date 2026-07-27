<?php

namespace App\Services\Estimate;

use App\Models\EstimateModel;
use Illuminate\Support\Str;

class EstimateShareService
{
    public function generatePublicLink(EstimateModel $estimate): string
    {
        if (!$estimate->share_token) {

            do {
                $token = Str::random(6);
            } while (
                EstimateModel::where('share_token', $token)->exists()
            );

            $estimate->share_token = $token;
        }

        $estimate->public_link_expires_at = now()->addDays(7);

        $estimate->save();

        return route('download.estimate.securelink', [
            'token' => $estimate->share_token
        ]);
    }

    public function isExpired(EstimateModel $estimate): bool
    {
        return $estimate->public_link_expires_at &&
            $estimate->public_link_expires_at->isPast();
    }

    public function sendWhatsAppEstimate(EstimateModel $estimate)
    {
        $shortcode = getShortcode('estimate', $estimate->estimate_code, $estimate->user_id);


        $data = [
            'client_name'     => $shortcode['{{client_name}}'],
            'company_name'    => $shortcode['{{user_company_name}}'],
            'estimate_number'  => $shortcode['{{estimate_number}}'],
            'estimate_date'    => $shortcode['{{estimate_date}}'],
            'expiry_date'        => $shortcode['{{estimate_due_date}}'],
            'amount'          => $shortcode['{{estimate_grand_total}}'],
            'total_due'       => $shortcode['{{estimate_final_amount}}'],
            'estimate_currency_symbol'       => $shortcode['{{estimate_currency_symbol}}'],
            'status'          => $estimate->status === 'paid' ? 'Paid' : 'Pending',
            'estimate_url'     => route('download.estimate.securelink', $estimate->share_token),
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

        $message = "*Estimate READY*\n";
        $message .= "{$divider}\n";
        $message .= "Hi {$data['client_name']},\n\n";
        $message .= "Thank you for choosing *{$data['company_name']}*. Your estimate has been generated and is ready for download.\n\n";
        $message .= "{$divider}\n";
        $message .= "```\n";
        $message .= "Estimate No.      {$data['estimate_number']}\n";
        $message .= "Estimate Date     {$data['estimate_date']}\n";
        $message .= "Expiry Date       {$data['expiry_date']}\n";
        $message .= "Amount            {$data['estimate_currency_symbol']} {$data['amount']}\n";
        $message .= "Due               {$data['estimate_currency_symbol']} {$data['total_due']}\n";
        $message .= "Status            {$data['status']}\n";
        $message .= "```\n";
        $message .= "{$divider}\n\n";
        $message .= "*Download Estimate (PDF)*\n";
        $message .= "{$data['estimate_url']}\n\n";
        $message .= "{$divider}\n\n";
        $message .= "If you've already completed the payment, please disregard this message.\n";
        $message .= "For any questions regarding this estimate, simply reply to this chat.\n";
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
