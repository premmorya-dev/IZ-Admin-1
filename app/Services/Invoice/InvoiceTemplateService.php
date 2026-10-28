<?php

namespace App\Services\Invoice;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InvoiceTemplateService
{
    // Bade base64 values: inpe cleanup regex nahi chalega
    private const IMAGE_KEYS = [
        '{{user_qrcode_image}}',
        '{{user_signature_image}}',
        '{{user_logo_image}}',
        '{{user_logo_path_base64_pdf}}',
    ];

    public function renderInvoiceHtml(string $invoiceCode): ?string
    {
        $userId = DB::table('invoices')
            ->where('invoice_code', $invoiceCode)
            ->value('user_id');

        if (!$userId) {
            return null;
        }

        // Poore render me sirf EK baar (pehle 3 baar)
        $data = getShortcode('invoice', $invoiceCode, $userId);

        if (empty($data)) {
            return null;
        }

        $templateId   = $data['{{invoice_template_id}}'] ?? null;
        $hideShipping = ($data['{{display_shipping_status}}'] ?? '') === 'N';

        $templateHtml = $this->getPreparedTemplate($templateId, $hideShipping);

        if ($templateHtml === null) {
            return null;
        }

        // Values ko string banao, images alag karo
        $data   = array_map(fn ($v) => is_scalar($v) || $v === null ? (string) $v : '', $data);
        $images = array_intersect_key($data, array_flip(self::IMAGE_KEYS));
        $text   = array_diff_key($data, $images);

        // Phase 1: text placeholders (strtr = single pass, sabse fast)
        $html = strtr($templateHtml, $text);
        $html = $this->normalize($html);

        // Phase 2: images cleanup ke baad (badi base64 strings pe regex nahi)
        return strtr($html, $images);
    }

    /**
     * Template DB se + cleanHtml + shipping block removal: sab cache.
     */
    private function getPreparedTemplate($templateId, bool $hideShipping): ?string
    {


       $content = DB::table('templates')
                ->where('template_id', $templateId)
                ->value('content');

            if ($content === null) {
                return null; // null cache nahi hota, theek hai
            }

            $content = $hideShipping
                ? preg_replace('/\{\{#shipping\}\}.*?\{\{\/shipping\}\}/s', '', $content)
                : str_replace(['{{#shipping}}', '{{/shipping}}'], '', $content);

            return $this->cleanHtml((string) $content);

            
        if (empty($templateId)) {
            return null;
        }

        $key = 'invoice_tpl:' . $templateId . ':' . ($hideShipping ? 'noship' : 'ship');

        return Cache::remember($key, now()->addDay(), function () use ($templateId, $hideShipping) {
            $content = DB::table('templates')
                ->where('template_id', $templateId)
                ->value('content');

            if ($content === null) {
                return null; // null cache nahi hota, theek hai
            }

            $content = $hideShipping
                ? preg_replace('/\{\{#shipping\}\}.*?\{\{\/shipping\}\}/s', '', $content)
                : str_replace(['{{#shipping}}', '{{/shipping}}'], '', $content);

            return $this->cleanHtml((string) $content);
        });
    }

    // Purane shortcode() ka cleanup, same behaviour
    private function normalize(string $message): string
    {
        $message = mb_convert_encoding($message, 'UTF-8', 'auto');
        $message = preg_replace('/\xA0/u', ' ', $message);
        $message = str_replace("\xc2\xa0", ' ', $message);
        $message = trim($message, "\xC2\xA0");
        $message = preg_replace(["/\s\s+/", "/\r\r+/", "/\n\n+/"], '', $message);

        return str_replace(["\r\n", "\r", "\n"], '', $message);
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