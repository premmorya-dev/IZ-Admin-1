<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>ITC Statement</title>
<style>
    @page { size: A4 portrait; margin: 26px 30px 62px 30px; }

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
    .sum td { padding: 14px 16px; vertical-align: top; border-right: 1px solid #1e293b; }
    .sum td:last-child { border-right: 0; }
    .sum .k { font-size: 7.5px; color: #a5b4fc; text-transform: uppercase; letter-spacing: 1.2px; }
    .sum .v { font-size: 14px; font-weight: bold; color: #ffffff; margin-top: 5px; }
    .sum .v.ok { color: #6ee7b7; }
    .sum .big { font-size: 19px; }

    /* ITC share bar */
    .bar-wrap { margin-top: 12px; }
    .bar-meta { width: 100%; font-size: 8px; color: #64748b; }
    .bar-meta b { color: #0f172a; }
    .bar { width: 100%; height: 6px; background: #e2e8f0; border-radius: 6px; margin-top: 5px; }
    .bar .fill { height: 6px; background: #4f46e5; border-radius: 6px; }

    /* ---------- table ---------- */
    .sec { margin: 20px 0 8px 0; font-size: 11px; font-weight: bold; color: #0f172a; }
    .sec span { font-weight: normal; color: #94a3b8; font-size: 9px; }

    .tbl { width: 100%; border: 1px solid #e2e8f0; }
    .tbl thead { display: table-header-group; }
    .tbl thead th { background: #f1f5f9; color: #64748b; font-size: 7.5px; text-transform: uppercase; letter-spacing: 0.8px;
        padding: 9px 8px; text-align: left; border-bottom: 1px solid #cbd5e1; }
    .tbl tbody td { padding: 9px 8px; border-bottom: 1px solid #eef2f7; vertical-align: middle; }
    .tbl tbody tr { page-break-inside: avoid; }
    .tbl tbody tr.alt td { background: #fafbff; }
    .tbl .r { text-align: right; }
    .tbl .idx { color: #94a3b8; }
    .inv { font-weight: bold; color: #0f172a; }
    .grand { font-weight: bold; color: #0f172a; }
    .itc { font-weight: bold; color: #047857; }
    .itc-pct { font-size: 7.5px; color: #94a3b8; }

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

    $itc   = (float) $summary['total_tax'];
    $grand = (float) $summary['total_grand'];

    $count  = collect($bills)->count();
    $avgItc = $count > 0 ? $itc / $count : 0;

    // ITC total purchases ka kitna % hai
    $pct     = $grand > 0 ? max(0, min(100, round(($itc / $grand) * 100, 1))) : 0;
    $pctText = rtrim(rtrim(number_format($pct, 1), '0'), '.');

    $dates     = collect($bills)->pluck('bill_date')->filter()->map(fn($d) => \Carbon\Carbon::parse($d))->sort();
    $rangeText = $dates->count() ? $dates->first()->format('d M Y') . '  -  ' . $dates->last()->format('d M Y') : 'All records';

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
            <td>Invoicezy &middot; ITC Statement &middot; Generated on {{ now()->format('d M Y, h:i A') }}</td>
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
            <div class="t">ITC Statement</div>
            <div class="s">{{ $rangeText }} &nbsp;|&nbsp; {{ $count }} bill{{ $count == 1 ? '' : 's' }}</div>
        </td>
    </tr>
</table>

<!-- SUMMARY STRIP -->
<table class="sum">
    <tr>
        <td style="width:34%">
            <div class="k">Input tax credit claim</div>
            <div class="v big ok">{{ $f($summary['total_tax']) }}</div>
        </td>
        <td style="width:30%">
            <div class="k">Total purchases</div>
            <div class="v">{{ $f($summary['total_grand']) }}</div>
        </td>
        <td style="width:14%">
            <div class="k">Bills</div>
            <div class="v">{{ $count }}</div>
        </td>
        <td style="width:22%">
            <div class="k">Avg ITC / bill</div>
            <div class="v">{{ $f($avgItc) }}</div>
        </td>
    </tr>
</table>

<!-- ITC SHARE BAR -->
<div class="bar-wrap">
    <table class="bar-meta">
        <tr>
            <td>ITC share of purchases <b>{{ $pctText }}%</b></td>
            <td style="text-align:right">Total purchases <b>{{ $f($grand) }}</b></td>
        </tr>
    </table>
    <div class="bar"><div class="fill" style="width: {{ $pct }}%;"></div></div>
</div>

<!-- TABLE -->
<div class="sec">Transaction details <span>&nbsp;&middot;&nbsp; {{ $count }} record{{ $count == 1 ? '' : 's' }}</span></div>

<table class="tbl">
    <thead>
        <tr>
            <th style="width:6%">#</th>
            <th style="width:24%">Bill #</th>
            <th style="width:20%">Date</th>
            <th class="r" style="width:24%">Grand Total</th>
            <th class="r" style="width:26%">Input Tax Credit</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($bills as $key => $bill)
        @php
            $rowPct = (float) $bill->grand_total > 0 ? round(((float) $bill->total_tax / (float) $bill->grand_total) * 100, 1) : 0;
        @endphp
        <tr class="{{ $key % 2 ? 'alt' : '' }}">
            <td class="idx">{{ $key + 1 }}</td>
            <td><span class="inv">{{ $bill->bill_number }}</span></td>
            <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
            <td class="r grand">{{ $f($bill->grand_total) }}</td>
            <td class="r">
                <span class="itc">{{ $f($bill->total_tax) }}</span><br>
                <span class="itc-pct">{{ rtrim(rtrim(number_format($rowPct, 1), '0'), '.') }}% of bill</span>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="empty">No ITC found for the selected criteria.</td>
        </tr>
        @endforelse
    </tbody>

    @if($count)
    <tfoot>
        <tr>
            <th colspan="3" class="lbl">Total</th>
            <th>{{ $f($summary['total_grand']) }}</th>
            <th>{{ $f($summary['total_tax']) }}</th>
        </tr>
    </tfoot>
    @endif
</table>

</body>
</html>