<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Invoice Statement</title>
<style>
    @page { size: A4 landscape; margin: 26px 30px 62px 30px; }

    * { box-sizing: border-box; }
    body { margin: 0; font-family: DejaVu Sans, Helvetica, Arial, sans-serif; font-size: 9px; color: #334155; line-height: 1.4; }
    table { border-collapse: collapse; }

    /* ---------- header ---------- */
    .hdr { width: 100%; border-bottom: 4px solid #4f46e5; }
    .hdr td { padding: 0 0 14px 0; vertical-align: middle; }
    .brand-logo { height: 38px; }
    .brand-name { font-size: 20px; font-weight: bold; color: #0f172a; letter-spacing: -0.5px; }
    .brand-name span { color: #4f46e5; }
    .doc-title { text-align: right; }
    .doc-title .t { font-size: 20px; font-weight: bold; color: #0f172a; letter-spacing: -0.5px; }
    .doc-title .s { font-size: 9px; color: #64748b; margin-top: 3px; }

    /* ---------- summary strip ---------- */
    .sum { width: 100%; margin-top: 16px; background: #0f172a; border-radius: 10px; }
    .sum td { padding: 14px 18px; vertical-align: top; border-right: 1px solid #1e293b; }
    .sum td:last-child { border-right: 0; }
    .sum .k { font-size: 7.5px; color: #a5b4fc; text-transform: uppercase; letter-spacing: 1.2px; }
    .sum .v { font-size: 15px; font-weight: bold; color: #ffffff; margin-top: 5px; }
    .sum .v.ok { color: #6ee7b7; }
    .sum .v.bad { color: #fda4af; }
    .sum .big { font-size: 19px; }

    /* collected bar */
    .bar-wrap { margin-top: 12px; }
    .bar-meta { width: 100%; font-size: 8px; color: #64748b; }
    .bar-meta b { color: #0f172a; }
    .bar { width: 100%; height: 6px; background: #e2e8f0; border-radius: 6px; margin-top: 5px; }
    .bar .fill { height: 6px; background: #4f46e5; border-radius: 6px; }

    .note { margin-top: 12px; padding: 8px 12px; background: #fffbeb; border: 1px solid #fde68a; border-radius: 6px; font-size: 8px; color: #b45309; }

    /* ---------- table ---------- */
    .sec { margin: 20px 0 8px 0; font-size: 11px; font-weight: bold; color: #0f172a; }
    .sec span { font-weight: normal; color: #94a3b8; font-size: 9px; }

    .tbl { width: 100%; border: 1px solid #e2e8f0; }
    .tbl thead th { background: #f1f5f9; color: #64748b; font-size: 7.5px; text-transform: uppercase; letter-spacing: 0.8px;
        padding: 9px 8px; text-align: left; border-bottom: 1px solid #cbd5e1; }
    .tbl tbody td { padding: 9px 8px; border-bottom: 1px solid #eef2f7; vertical-align: middle; }
    .tbl tbody tr { page-break-inside: avoid; }
    .tbl tbody tr.alt td { background: #fafbff; }
    .tbl .r { text-align: right; }
    .tbl .idx { color: #94a3b8; }
    .inv { font-weight: bold; color: #0f172a; }
    .grand { font-weight: bold; color: #0f172a; }
    .paid { color: #047857; font-weight: bold; }
    .due-owe { color: #be123c; font-weight: bold; }
    .due-zero { color: #94a3b8; }
    .cur { background: #f1f5f9; color: #475569; padding: 1px 6px; border-radius: 4px; font-size: 8px; font-weight: bold; }

    .badge { padding: 2px 8px; border-radius: 10px; font-size: 7.5px; font-weight: bold; }
    .b-paid { background: #d1fae5; color: #047857; }
    .b-sent { background: #dbeafe; color: #1d4ed8; }
    .b-pending { background: #fef3c7; color: #b45309; }
    .b-overdue { background: #ffe4e6; color: #be123c; }
    .b-cancelled { background: #e2e8f0; color: #64748b; }

    .tbl tfoot th { background: #0f172a; color: #ffffff; padding: 11px 8px; text-align: right; font-size: 9px; }
    .tbl tfoot th.lbl { text-align: right; color: #a5b4fc; text-transform: uppercase; letter-spacing: 1px; font-size: 8px; }

    .empty { text-align: center; padding: 40px 10px; color: #64748b; font-size: 11px; }

    /* ---------- footer ---------- */
    .footer { position: fixed; bottom: -42px; left: 0; right: 0; height: 30px; border-top: 1px solid #e2e8f0; padding-top: 7px; font-size: 7.5px; color: #94a3b8; }
    .footer table { width: 100%; }
    .footer .pn:before { content: "Page " counter(page); }
</style>
</head>
<body>

@php
    $f = fn($n) => number_format((float) $n, 2);

    $grand     = (float) $summary['total_grand'];
    $collected = (float) $summary['total_advance'];
    $due       = (float) $summary['total_due'];
    $pct       = $grand > 0 ? max(0, min(100, round(($collected / $grand) * 100, 1))) : 0;
    $pctText   = rtrim(rtrim(number_format($pct, 1), '0'), '.');

    $count      = collect($invoices)->count();
    $currencies = collect($invoices)->pluck('currency_code')->filter()->unique();
    $dates      = collect($invoices)->pluck('invoice_date')->filter()->map(fn($d) => \Carbon\Carbon::parse($d))->sort();
    $rangeText  = $dates->count() ? $dates->first()->format('d M Y') . '  -  ' . $dates->last()->format('d M Y') : 'All records';

    // logo embed (remote/relative path problems se bachne ke liye)
    $logo = null;
    foreach (['logo.png', 'logo.jpg'] as $file) {
        if (file_exists(public_path($file))) {
            $mime = str_ends_with($file, '.png') ? 'image/png' : 'image/jpeg';
            $logo = 'data:' . $mime . ';base64,' . base64_encode(file_get_contents(public_path($file)));
            break;
        }
    }
@endphp

<!-- FOOTER (har page pe) -->
<div class="footer">
    <table>
        <tr>
            <td>Invoicezy &middot; Invoice Statement &middot; Generated on {{ now()->format('d M Y, h:i A') }}</td>
            <td style="text-align:right"><span class="pn"></span></td>
        </tr>
    </table>
</div>

<!-- HEADER -->
<table class="hdr">
    <tr>
        <td style="width:50%">
            @if($logo)
                <img src="{{ $logo }}" class="brand-logo" alt="Invoicezy">
            @else
                <div class="brand-name">Invoice<span>zy</span></div>
            @endif
        </td>
        <td class="doc-title" style="width:50%">
            <div class="t">Invoice Statement</div>
            <div class="s">{{ $rangeText }} &nbsp;|&nbsp; {{ $count }} invoice{{ $count == 1 ? '' : 's' }}</div>
        </td>
    </tr>
</table>

<!-- SUMMARY STRIP -->
<table class="sum">
    <tr>
        <td style="width:28%">
            <div class="k">Grand total</div>
            <div class="v big">{{ $f($summary['total_grand']) }}</div>
        </td>
        <td style="width:18%">
            <div class="k">Subtotal</div>
            <div class="v">{{ $f($summary['total_sub_total']) }}</div>
        </td>
        <td style="width:14%">
            <div class="k">Tax</div>
            <div class="v">{{ $f($summary['total_tax']) }}</div>
        </td>
        <td style="width:14%">
            <div class="k">Discount</div>
            <div class="v">{{ $f($summary['total_discount']) }}</div>
        </td>
        <td style="width:13%">
            <div class="k">Paid</div>
            <div class="v ok">{{ $f($summary['total_advance']) }}</div>
        </td>
        <td style="width:13%">
            <div class="k">Total due</div>
            <div class="v {{ $due > 0 ? 'bad' : 'ok' }}">{{ $f($summary['total_due']) }}</div>
        </td>
    </tr>
</table>

<!-- COLLECTED BAR -->
<div class="bar-wrap">
    <table class="bar-meta">
        <tr>
            <td>Collected <b>{{ $f($collected) }}</b> ({{ $pctText }}%)</td>
            <td style="text-align:right">Outstanding <b>{{ $f($due) }}</b></td>
        </tr>
    </table>
    <div class="bar"><div class="fill" style="width: {{ $pct }}%;"></div></div>
</div>

@if($currencies->count() > 1)
<div class="note">
    This statement contains invoices in multiple currencies ({{ $currencies->implode(', ') }}). Totals add up amounts as they are, without currency conversion.
</div>
@endif

<!-- TABLE -->
<div class="sec">Transaction details <span>&nbsp;&middot;&nbsp; {{ $count }} record{{ $count == 1 ? '' : 's' }}</span></div>

<table class="tbl">
    <thead>
        <tr>
            <th style="width:3%">#</th>
            <th style="width:12%">Invoice #</th>
            <th style="width:10%">Date</th>
            <th style="width:9%">Status</th>
            <th style="width:7%">Currency</th>
            <th class="r" style="width:10%">Subtotal</th>
            <th class="r" style="width:8%">Tax</th>
            <th class="r" style="width:8%">Discount</th>
            <th class="r" style="width:11%">Grand Total</th>
            <th class="r" style="width:11%">Paid</th>
            <th class="r" style="width:11%">Total Due</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($invoices as $key => $invoice)
        @php
            $st = strtolower($invoice->status ?? '');
            $badge = in_array($st, ['paid','sent','pending','overdue','cancelled']) ? $st : 'cancelled';
        @endphp
        <tr class="{{ $key % 2 ? 'alt' : '' }}">
            <td class="idx">{{ $key + 1 }}</td>
            <td><span class="inv">{{ $invoice->invoice_number }}</span></td>
            <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</td>
            <td><span class="badge b-{{ $badge }}">{{ ucfirst($invoice->status) }}</span></td>
            <td><span class="cur">{{ $invoice->currency_code }}</span></td>
            <td class="r">{{ $f($invoice->sub_total) }}</td>
            <td class="r">{{ $f($invoice->total_tax) }}</td>
            <td class="r">{{ $f($invoice->total_discount) }}</td>
            <td class="r grand">{{ $f($invoice->grand_total) }}</td>
            <td class="r paid">{{ $f($invoice->advance_payment) }}</td>
            <td class="r {{ $invoice->total_due > 0 ? 'due-owe' : 'due-zero' }}">{{ $f($invoice->total_due) }}</td>
        </tr>
        @empty
        <tr>
            <td colspan="11" class="empty">No invoices found for the selected criteria.</td>
        </tr>
        @endforelse
    </tbody>

    @if($count)
    <tfoot>
        <tr>
            <th colspan="5" class="lbl">Total</th>
            <th>{{ $f($summary['total_sub_total']) }}</th>
            <th>{{ $f($summary['total_tax']) }}</th>
            <th>{{ $f($summary['total_discount']) }}</th>
            <th>{{ $f($summary['total_grand']) }}</th>
            <th>{{ $f($summary['total_advance']) }}</th>
            <th>{{ $f($summary['total_due']) }}</th>
        </tr>
    </tfoot>
    @endif
</table>

</body>
</html>