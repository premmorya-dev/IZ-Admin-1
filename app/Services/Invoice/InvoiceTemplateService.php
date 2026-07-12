<?php

namespace App\Services\Invoice;

use Illuminate\Support\Facades\DB;

class InvoiceTemplateService
{
    public function renderInvoiceHtml(string $invoiceCode): ?string
    {
       
       
        $invoiceTemplateId = shortcode('invoice', $invoiceCode, '{{invoice_template_id}}');
        $template = DB::table('templates')->where('template_id', $invoiceTemplateId)->first();

        if (!$template) {
            return null;
        }

        $html = $this->cleanHtml((string) ($template->content ?? ''));

        return shortcode('invoice', $invoiceCode, $html);
    }

    public function cleanHtml(string $html): string
    {
        $html = preg_replace([
            '/\>[^\S ]+/s',
            '/[^\S ]+\</s',
            '/(\s)+/s',
            '/<!--(.|\s)*?-->/',
        ], ['>', '<', '\\1', ''], $html);

        return preg_replace([
            '/>\s+</',
            '/\s{2,}/',
            '/<!--(.*?)-->/',
        ], ['><', ' ', ''], $html);
    }
}
