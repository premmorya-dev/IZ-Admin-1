<?php

namespace App\Services\Invoice;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InvoiceFilterService
{
    /**
     * List me sirf ye columns laate hain.
     * item_json / notes / terms bhari hain aur listing me kaam nahi aate
     * (agar view inme se kuch use karta hai to yahan add kar do).
     */
    private const LIST_COLUMNS = [
        'invoice_id', 'user_id', 'client_id', 'invoice_number', 'invoice_code', 'invoice_date', 'due_date',
        'status', 'sub_total', 'total_tax', 'total_tax_percent', 'taxable_value', 'cgst_amount', 'sgst_amount',
        'igst_amount', 'total_discount', 'grand_total', 'round_off', 'advance_payment', 'total_due',
        'currency_code', 'upi_id', 'template_id', 'share_token', 'public_link_expires_at',
        'is_sent', 'is_paid', 'is_overdue', 'is_cancelled', 'display_shipping_status',
        'sent_at', 'paid_at', 'cancelled_at', 'overdue_at', 'created_at', 'updated_at',
    ];

    private const MAX_PER_PAGE = 1000;

    public function getIndexData(Request $request): array
    {
        $userId = Auth::id();

        $limit  = $request->filled('pagination_per_page') ? (int) $request->input('pagination_per_page') : 10;
        $limit  = min(max($limit, 1), self::MAX_PER_PAGE);
        $page   = max(1, (int) $request->get('page', 1));
        $offset = ($page - 1) * $limit;

        // pagination url
        $queryParams = $request->query();
        unset($queryParams['page']);
        $newQueryString = http_build_query($queryParams);
        $paginationUrl  = url()->current()
            . (!empty($newQueryString) ? '?' . $newQueryString . '&page=' : '?page=');

        // sorting (whitelist)
        $sortMap = [
            'invoice_id'     => 'invoices.invoice_id',
            'invoice_number' => 'invoices.invoice_number',
            'invoice_date'   => 'invoices.invoice_date',
            'due_date'       => 'invoices.due_date',
            'status'         => 'invoices.status',
            'sub_total'      => 'invoices.sub_total',
            'total'          => 'invoices.grand_total',
            'created_at'     => 'invoices.created_at',
            'updated_at'     => 'invoices.updated_at',
        ];

        $direction = strtolower((string) $request->input('direction', 'desc')) === 'asc' ? 'asc' : 'desc';
        $sortKey   = $request->input('sort');
        $sort      = !empty($sortKey) && isset($sortMap[$sortKey]) ? $sortMap[$sortKey] : 'invoices.invoice_id';

        // clients table ka join tabhi, jab client/company se filter ho
        $needsClientJoin = $request->filled('client_name') || $request->filled('company_name');

        $baseQuery = DB::table('invoices')->where('invoices.user_id', $userId);

        if ($needsClientJoin) {
            $baseQuery->leftJoin('clients', 'invoices.client_id', '=', 'clients.client_id');
        }

        $this->applyFilters($baseQuery, $request);

        // 1) total count (composite index se covering scan)
        $totalRecords = (clone $baseQuery)->count('invoices.invoice_id');
        $totalPages   = (int) ceil($totalRecords / $limit);

        $empty = [
            'page'            => $page,
            'perPage'         => $limit,
            'offset'          => $offset,
            'pagination_url'  => $paginationUrl,
            'totalRecords'    => $totalRecords,
            'totalPages'      => $totalPages,
            'show_pagination' => false,
            'invoice'         => collect(),
        ];

        if ($totalRecords === 0 || $offset >= $totalRecords) {
            return $empty;
        }

        // 2) sirf IDs nikalo (index-only), tie-breaker ke saath taaki pages stable rahein
        $idQuery = (clone $baseQuery)
            ->select('invoices.invoice_id')
            ->orderBy($sort, $direction);

        if ($sort !== 'invoices.invoice_id') {
            $idQuery->orderBy('invoices.invoice_id', $direction);
        }

        $invoiceIds = $idQuery->offset($offset)->limit($limit)->pluck('invoice_id')->all();

        if (empty($invoiceIds)) {
            return $empty;
        }

        // 3) un IDs ki full rows (PK lookup), sort PHP me, filesort nahi
        $rows = DB::table('invoices')
            ->select(array_merge(
                array_map(fn ($c) => 'invoices.' . $c, self::LIST_COLUMNS),
                ['clients.company_name', 'clients.client_name', 'clients.client_code']
            ))
            ->leftJoin('clients', 'invoices.client_id', '=', 'clients.client_id')
            ->where('invoices.user_id', $userId)
            ->whereIn('invoices.invoice_id', $invoiceIds)
            ->get()
            ->keyBy('invoice_id');

        $invoices = collect($invoiceIds)
            ->map(fn ($id) => $rows->get($id))
            ->filter()
            ->values();

        // 4) lookups: query nahi, cache + ek hi baar
        $user  = Auth::user();
        $tzId  = $user->time_zone_id ?? null;

        $tzName = $tzId
            ? Cache::remember("tz_name:{$tzId}", 86400, fn () => DB::table('time_zone')->where('time_zone_id', $tzId)->value('timezone'))
            : null;

        $symbols = Cache::remember('currency_symbols', 86400, function () {
            return DB::table('currencies')->pluck('currency_symbol', 'currency_code')->all();
        });

        $todayStart = $tzName ? Carbon::now($tzName)->startOfDay() : null;

        $localize = function ($value, string $in, string $out) use ($user, $tzId) {
            return (!empty($value) && $user) ? getTimeDateDisplay($tzId, $value, $in, $out) : '';
        };

        foreach ($invoices as $invoice) {
            $invoice->symbol = $symbols[$invoice->currency_code] ?? '';

            $invoice->invoice_date_utc = $invoice->invoice_date;
            $invoice->invoice_date     = $localize($invoice->invoice_date, 'Y-m-d', 'Y-m-d');

            $invoice->due_date_utc = $invoice->due_date;
            $invoice->due_date     = $localize($invoice->due_date, 'Y-m-d', 'Y-m-d');

            $invoice->created_at_utc = $invoice->created_at;
            $invoice->created_at     = $localize($invoice->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s');

            $invoice->updated_at_utc = $invoice->updated_at;
            $invoice->updated_at     = $localize($invoice->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s');

            if ($todayStart) {
                if (!empty($invoice->due_date_utc)) {
                    $dueDate = Carbon::parse($invoice->due_date_utc, $tzName)->startOfDay();
                    $days    = (int) abs($dueDate->diffInDays($todayStart));

                    if ($dueDate->lt($todayStart)) {
                        $invoice->due_status_text = 'Due for ' . $days . ' day(s)';
                        $invoice->due_type        = 'overdue';
                    } elseif ($dueDate->gt($todayStart)) {
                        $invoice->due_status_text = 'Due in ' . $days . ' day(s)';
                        $invoice->due_type        = 'upcoming';
                    } else {
                        $invoice->due_status_text = 'Due today';
                        $invoice->due_type        = 'today';
                    }
                } else {
                    $invoice->due_status_text = 'N/A';
                    $invoice->due_type        = 'unknown';
                }
            }
        }

        return [
            'page'            => $page,
            'perPage'         => $limit,
            'offset'          => $offset,
            'pagination_url'  => $paginationUrl,
            'totalRecords'    => $totalRecords,
            'totalPages'      => $totalPages,
            'show_pagination' => true,
            'invoice'         => $invoices,
        ];
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('invoice_number')) {
            $query->where('invoices.invoice_number', 'like', '%' . trim($request->input('invoice_number')) . '%');
        }

        if ($request->filled('client_name')) {
            $query->where('clients.client_name', 'like', '%' . trim($request->input('client_name')) . '%');
        }

        if ($request->filled('company_name')) {
            $query->where('clients.company_name', 'like', '%' . trim($request->input('company_name')) . '%');
        }

        if ($request->filled('status')) {
            $status = array_values(array_filter(array_map('trim', explode(',', (string) $request->input('status')))));
            if (!empty($status)) {
                $query->whereIn('invoices.status', $status);
            }
        }

        if ($request->filled('issue_date') && str_contains((string) $request->input('issue_date'), ' - ')) {
            $issueDate = $this->parseDateRange($request->input('issue_date'));
            $query->where('invoices.invoice_date', '>=', $this->convertToUTC($issueDate['start_date']));
            $query->where('invoices.invoice_date', '<=', $this->convertToUTC($issueDate['end_date']));
        }

        if ($request->filled('sub_total')) {
            $query->where('invoices.sub_total', '=', $request->input('sub_total'));
        }

        if ($request->filled('tax_total')) {
            $query->where('invoices.total_tax', '=', $request->input('tax_total'));
        }

        if ($request->filled('discount')) {
            $query->where('invoices.total_discount', '=', $request->input('discount'));
        }

        if ($request->filled('total')) {
            $query->where('invoices.grand_total', '=', $request->input('total'));
        }

        if ($request->filled('currency')) {
            $query->where('invoices.currency_code', '=', $request->input('currency'));
        }
    }

    public function parseDateRange(string $dateTimeRange): array
    {
        [$start, $end] = array_pad(explode(' - ', $dateTimeRange, 2), 2, '');

        return [
            'start_date' => trim($start),
            'end_date'   => trim($end),
        ];
    }

    public function convertToUTC(string $dateTime, string $timezone = 'Asia/Kolkata'): string
    {
        return Carbon::createFromFormat('Y-m-d', $dateTime, $timezone)
            ->setTimezone('UTC')
            ->toDateTimeString();
    }
}