<?php

namespace App\Services\Invoice;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceFilterService
{
    public function getIndexData(Request $request): array
    {
        $limit = $request->filled('pagination_per_page') ? (int) $request->input('pagination_per_page') : 10;
        $page = (int) $request->get('page', 1);
        $offset = ($page - 1) * $limit;

        $queryParams = $request->query();
        unset($queryParams['page']);
        $newQueryString = http_build_query($queryParams);

        if (($request->has('filters') && $request->input('filters') == 'true') || $request->has('direction')) {
            $paginationUrl = url()->current() . (!empty($newQueryString) ? '?' . $newQueryString : '') . '&page=';
        } else {
            $paginationUrl = url()->current() . (!empty($newQueryString) ? '?' . $newQueryString : '') . '?page=';
        }

        $sortMap = [
            'invoice_id' => 'invoices.invoice_id',
            'invoice_number' => 'invoices.invoice_number',
            'invoice_date' => 'invoices.invoice_date',
            'due_date' => 'invoices.due_date',
            'status' => 'invoices.status',
            'sub_total' => 'invoices.sub_total',
            'total' => 'invoices.grand_total',
            'created_at' => 'invoices.created_at',
            'updated_at' => 'invoices.updated_at',
        ];

        $orderBy = $request->input('direction', 'desc');
        $sort = !empty($request->input('sort')) && array_key_exists($request->input('sort'), $sortMap)
            ? $sortMap[$request->input('sort')]
            : 'invoices.invoice_id';

        $baseQuery = DB::table('invoices')
            ->leftJoin('clients', 'invoices.client_id', 'clients.client_id')
            ->where('invoices.user_id', Auth::id());

        $this->applyFilters($baseQuery, $request);

        $totalRecords = (clone $baseQuery)->count('invoices.invoice_id');
        $totalPages = (int) ceil($totalRecords / $limit);

        $invoiceIds = (clone $baseQuery)
            ->select('invoices.invoice_id')
            ->orderBy($sort, $orderBy)
            ->offset($offset)
            ->limit($limit)
            ->pluck('invoice_id')
            ->all();

        $showPagination = !empty($invoiceIds);

        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $timezone = $user ? DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first() : null;

        $invoices = collect();

        if (!empty($invoiceIds)) {
            $invoices = DB::table('invoices')
                ->select(
                    'invoices.*',
                    'clients.company_name',
                    'clients.client_name',
                    'clients.client_code'
                )
                ->leftJoin('clients', 'invoices.client_id', 'clients.client_id')
                ->where('invoices.user_id', Auth::id())
                ->whereIn('invoices.invoice_id', $invoiceIds)
                ->orderBy($sort, $orderBy)
                ->get();

            foreach ($invoices as $key => $invoice) {
                $currencySymbol = DB::table('currencies')->where('currency_code', $invoice->currency_code)->value('currency_symbol');
                $invoices[$key]->symbol = $currencySymbol ?? '';

                $invoices[$key]->invoice_date_utc = $invoice->invoice_date;
                $invoices[$key]->invoice_date = !empty($invoice->invoice_date) && $user
                    ? getTimeDateDisplay($user->time_zone_id, $invoice->invoice_date, 'Y-m-d', 'Y-m-d')
                    : '';

                $invoices[$key]->due_date_utc = $invoice->due_date;
                $invoices[$key]->due_date = !empty($invoice->due_date) && $user
                    ? getTimeDateDisplay($user->time_zone_id, $invoice->due_date, 'Y-m-d', 'Y-m-d')
                    : '';

                $invoices[$key]->created_at_utc = $invoice->created_at;
                $invoices[$key]->created_at = !empty($invoice->created_at) && $user
                    ? getTimeDateDisplay($user->time_zone_id, $invoice->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s')
                    : '';

                $invoices[$key]->updated_at_utc = $invoice->updated_at;
                $invoices[$key]->updated_at = !empty($invoice->updated_at) && $user
                    ? getTimeDateDisplay($user->time_zone_id, $invoice->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s')
                    : '';

                if (!empty($timezone)) {
                    $today = Carbon::now($timezone->timezone);
                    if (!empty($invoice->due_date_utc)) {
                        $dueDate = Carbon::parse($invoice->due_date_utc);

                        if ($dueDate->lt($today)) {
                            $invoices[$key]->due_status_text = 'Due for ' . $dueDate->diffInDays($today) . ' day(s)';
                            $invoices[$key]->due_type = 'overdue';
                        } elseif ($dueDate->gt($today)) {
                            $invoices[$key]->due_status_text = 'Due in ' . $today->diffInDays($dueDate) . ' day(s)';
                            $invoices[$key]->due_type = 'upcoming';
                        } else {
                            $invoices[$key]->due_status_text = 'Due today';
                            $invoices[$key]->due_type = 'today';
                        }
                    } else {
                        $invoices[$key]->due_status_text = 'N/A';
                        $invoices[$key]->due_type = 'unknown';
                    }
                }
            }
        }

        return [
            'page' => $page,
            'perPage' => $limit,
            'offset' => $offset,
            'pagination_url' => $paginationUrl,
            'totalRecords' => $totalRecords,
            'totalPages' => $totalPages,
            'show_pagination' => $showPagination,
            'invoice' => $invoices,
        ];
    }

    private function applyFilters($query, Request $request): void
    {
        if ($request->filled('invoice_number')) {
            $query->where('invoices.invoice_number', 'Like', '%' . $request->input('invoice_number') . '%');
        }

        if ($request->filled('client_name')) {
            $query->where('clients.client_name', 'Like', '%' . $request->input('client_name') . '%');
        }

        if ($request->filled('company_name')) {
            $query->where('clients.company_name', 'Like', '%' . $request->input('company_name') . '%');
        }

        if ($request->filled('status')) {
            $status = explode(',', $request->input('status'));
            $query->whereIn('invoices.status', $status);
        }

        if ($request->filled('issue_date')) {
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
        [$start, $end] = explode(' - ', $dateTimeRange);

        return [
            'start_date' => $start,
            'end_date' => $end,
        ];
    }

    public function convertToUTC(string $dateTime, string $timezone = 'Asia/Kolkata'): string
    {
        return Carbon::createFromFormat('Y-m-d', $dateTime, $timezone)
            ->setTimezone('UTC')
            ->toDateTimeString();
    }
}
