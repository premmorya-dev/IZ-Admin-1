<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\InvoiceModel;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller
{






    public function generateFullGSTR1(Request $request)
    {


        $period = $request->input('period'); // e.g., "062025"
        $month = (int)substr($period, 0, 2); // 06
        $year = (int)substr($period, 2, 4);  // 2025

        // Get current period invoices
        $invoices = InvoiceModel::whereYear('invoice_date', $year)
            ->whereMonth('invoice_date', $month)
            ->where('user_id', Auth::id())
            ->get();



        // Gross Turnover (previous FY: April 1 of last year to March 31 of this year)
        $gtStart = Carbon::create($year - 1, 4, 1)->startOfDay();
        $gtEnd = Carbon::create($year, 3, 31)->endOfDay();

        $gstr1Data = [
            'gstin' => setting('user_gst_number'),
            'fp' => $period,
            'gt' => InvoiceModel::whereBetween('invoice_date', [$gtStart, $gtEnd])->where('user_id', Auth::id())->sum('grand_total'),
            'cur_gt' => $invoices->sum('grand_total'),
            'b2b' => [],
            'b2cl' => [],
            'b2c' => [],
        ];



        $b2bGrouped = [];

        foreach ($invoices as $invoice) {

            $items = DB::table('invoices')
                ->leftJoin('clients', 'clients.client_id', 'invoices.client_id')
                ->leftJoin('country_states', 'country_states.state_id', 'clients.state_id')
                ->where('invoices.invoice_id', $invoice->invoice_id)
                ->where('invoices.user_id', Auth::id())
                ->first();
            $place_of_supply =   $items->code;

            if (!empty($invoice->client_id) && !empty($items->gst_number)) {
                // B2B Invoice
                $ctin = $items->gst_number;

                if (!isset($b2bGrouped[$ctin])) {
                    $b2bGrouped[$ctin] = [
                        'ctin' => $ctin,
                        'inv' => [],
                    ];
                }

                $b2bGrouped[$ctin]['inv'][] = $this->formatInvoice($invoice);
            } elseif ($invoice->grand_total > 250000 && $this->isInterState($invoice)) {
                // B2CL Invoice (inter-state, value > 2.5L)
                $gstr1Data['b2cl'][] = [
                    'pos' => $place_of_supply,
                    'inv' => [$this->formatInvoice($invoice)],
                ];
            } else {
                // B2C Invoice (intra-state or < 2.5L)
                $gstr1Data['b2c'][] = [
                    'pos' => $place_of_supply,
                    'inv' => [$this->formatInvoice($invoice)],
                ];
            }
        }

        $gstr1Data['b2b'] = array_values($b2bGrouped);



        // Save to temp file and return response
        $filename = "GSTR1_{$period}.json";
        $jsonContent = json_encode($gstr1Data, JSON_PRETTY_PRINT);

        return response($jsonContent)
            ->header('Content-Type', 'application/json')
            ->header('Content-Disposition', "attachment; filename={$filename}");
    }





    protected function formatInvoice(InvoiceModel $invoice)
    {

        $items = DB::table('invoices')
            ->leftJoin('clients', 'clients.client_id', 'invoices.client_id')
            ->leftJoin('country_states', 'country_states.state_id', 'clients.state_id')
            ->where('invoices.invoice_id', $invoice->invoice_id)
            ->where('invoices.user_id', Auth::id())
            ->first();
        $place_of_supply =   $items->code;



        $itemsJson = json_decode($invoice->item_json, true);
        $formattedItems = [];

        $i = 1;
        foreach ($itemsJson as $key => $item) {
            $taxableValue = round(floatval($item['rate']) * floatval($item['quantity']) - floatval($item['discount']), 2);
            $gstRate = floatval($item['tax']);
            $gstAmount = round(($taxableValue * $gstRate) / 100, 2);

            // Assuming intra-state (CGST + SGST)
            $halfGst = round($gstAmount / 2, 2);

            $formattedItems[] = [
                'num' => $i++,
                'itm_det' => [
                    'rt'    => $gstRate,
                    'txval' => $taxableValue,
                    'iamt'  => 0.00,      // IGST
                    'camt'  => $halfGst,  // CGST
                    'samt'  => $halfGst   // SGST
                ]
            ];
        }

        return [
            'inum'    => $invoice->invoice_number,
            'idt'     => \Carbon\Carbon::parse($invoice->invoice_date)->format('Y-m-d'),
            'val'     => round($invoice->grand_total, 2),
            'pos'     => $place_of_supply ?? '27', // Default POS
            'rchrg'   => ($invoice->reverse_charge ?? 'N') === 'Y' ? 'Y' : 'N',
            'inv_typ' => $invoice->invoice_type ?? 'R',
            'itms'    => $formattedItems
        ];
    }


    protected function isInterState(InvoiceModel $invoice)
    {



        $items = DB::table('invoices')
            ->leftJoin('clients', 'clients.client_id', 'invoices.client_id')
            ->leftJoin('country_states', 'country_states.state_id', 'clients.state_id')
            ->where('invoices.invoice_id', $invoice->invoice_id)
            ->where('invoices.user_id', Auth::id())
            ->first();


        $user_state = DB::table('country_states')
            ->where('state_id', setting('state_id'))
            ->first();

        $place_of_supply =   $items->code;
        $supplierStateCode =   $user_state->code;


        return $place_of_supply !== $supplierStateCode;
    }



    public function index(Request $request)
    {

        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        return view('pages/report.list', compact('data'));
    }



    public function getReport(Request $request)
    {

        if ($request->report_type === 'invoice') {
            return $this->getInvoiceReport($request);
        } else if ($request->report_type === 'bill') {
            return $this->getPurchaseReport($request);
        } else if ($request->report_type === 'itc') {
            return $this->getPurchaseReport($request);
        }
    }


    public function getPurchaseReport(Request  $request)
    {

        $validator = Validator::make($request->all(), [
            'report_type' => 'required|in:invoice,bill,itc',
            'period' => 'required|in:all_time,this_month,last_month,3_month,custom',
            'status' => 'array|nullable',
            'currency' => 'array|nullable',
            'client' => 'nullable|in:all_client,single_client',
            'client_id' => 'nullable|integer|exists:clients,client_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 1,
                'errors' => $validator->errors()
            ]);
        }

        $query = DB::table('bills')
            ->select(
                'vendors.*',
                'bills.bill_number',
                'bills.bill_date',
                'bills.due_date',
                'bills.bill_status',
                'bills.currency_code',
                'bills.grand_total',
                'bills.total_tax',
                'bills.sub_total',
                'bills.total_discount',
                'bills.total_due',

            );

        $query->leftJoin('vendors', 'vendors.vendor_id', 'bills.vendor_id');

        $query->where('bills.user_id', Auth::id());

        // Period filter
        switch ($request->period) {
            case 'this_month':
                $query->whereBetween('bills.bill_date', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween('bills.bill_date', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                break;
            case '3_month':
                $query->whereBetween('bills.bill_date', [now()->subMonths(3)->startOfMonth(), now()]);
                break;
            case 'custom':

                if ($request->filled('date')) {
                    $date = $this->parseDateRange($request->input('date'));


                    $query->where('bills.bill_date', '>=',  convertToUTCDateOnly($date['start_date']));
                    $query->where('bills.bill_date', '<=',  convertToUTCDateOnly($date['end_date']));
                }
                break;
        }

        // Status filter
        if ($request->filled('bill_status')) {
            $query->whereIn('bills.bill_status',  $request->status);
        }

        // Currency filter
        if ($request->filled('currency')) {
            $query->whereIn('bills.currency_code', $request->currency);
        }

        // Vendor filter
        if ($request->vendor == 'single_vendor' && $request->filled('vendor_id')) {
            $query->where('vendors.vendor_id', $request->vendor_id);
        }

        $bills = $query->get();

        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


        foreach ($bills as $key => $bill) {
            $bill->bill_date_utc = $bill->bill_date;
            $bill->bill_date = !empty($bill->bill_date)
                ? getTimeDateDisplay($user->time_zone_id, $bill->bill_date, 'd-m-Y', 'Y-m-d')
                : '';
        }

        // Aggregate totals
        $summary = [
            'total_bills' => $bills->count(),
            'total_sub_total' => $bills->sum('sub_total'),
            'total_tax' => $bills->sum('total_tax'),
            'total_discount' => $bills->sum('total_discount'),
            'total_grand' => $bills->sum('grand_total'),
            'total_due' => $bills->sum('total_due'),
        ];

        if ($request->report_type === 'itc') {
            $html = view('pages/report.itc_report', compact('bills', 'summary'))->render();

            $report_pdf = view('pages/report.itc_report_pdf', compact('bills', 'summary'))->render();
        } else {
            $html = view('pages/report.purchase_report', compact('bills', 'summary'))->render();

            $report_pdf = view('pages/report.purchase_report_pdf', compact('bills', 'summary'))->render();
        }



        Session::put('report_statement', $report_pdf);
        return response()->json([
            'error' => 0,
            'message' => 'Report data fetched successfully.',
            'html' => $html
        ]);
    }

    public function getInvoiceReport(Request  $request)
    {

        $validator = Validator::make($request->all(), [
            'report_type' => 'required|in:invoice,bill,itc',
            'period' => 'required|in:all_time,this_month,last_month,3_month,custom',
            'status' => 'array|nullable',
            'currency' => 'array|nullable',
            'client' => 'nullable|in:all_client,single_client',
            'client_id' => 'nullable|integer|exists:clients,client_id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 1,
                'errors' => $validator->errors()
            ]);
        }

        $query = DB::table('invoices')
            ->select(
                'invoice_number',
                'invoice_date',
                'due_date',
                'status',
                'currency_code',
                'grand_total',
                'total_tax',
                'sub_total',
                'total_discount',
                'advance_payment',
                'total_due'
            );

        $query->where('invoices.user_id', Auth::id());

        // Period filter
        switch ($request->period) {
            case 'this_month':
                $query->whereBetween('invoice_date', [now()->startOfMonth(), now()->endOfMonth()]);
                break;
            case 'last_month':
                $query->whereBetween('invoice_date', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()]);
                break;
            case '3_month':
                $query->whereBetween('invoice_date', [now()->subMonths(3)->startOfMonth(), now()]);
                break;
            case 'custom':

                if ($request->filled('date')) {
                    $date = $this->parseDateRange($request->input('date'));


                    $query->where('invoices.invoice_date', '>=',  convertToUTCDateOnly($date['start_date']));
                    $query->where('invoices.invoice_date', '<=',  convertToUTCDateOnly($date['end_date']));
                }
                break;
        }

        // Status filter
        if ($request->filled('status')) {
            $query->whereIn('status',  $request->status);
        }

        // Currency filter
        if ($request->filled('currency')) {
            $query->whereIn('currency_code', $request->currency);
        }

        // Client filter
        if ($request->client == 'single_client' && $request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $invoices = $query->get();

        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


        foreach ($invoices as $key => $invoice) {
            $invoice->invoice_date_utc = $invoice->invoice_date;
            $invoice->invoice_date = !empty($invoice->invoice_date)
                ? getTimeDateDisplay($user->time_zone_id, $invoice->invoice_date, 'd-m-Y', 'Y-m-d')
                : '';
        }

        // Aggregate totals
        $summary = [
            'total_invoices' => $invoices->count(),
            'total_sub_total' => $invoices->sum('sub_total'),
            'total_tax' => $invoices->sum('total_tax'),
            'total_discount' => $invoices->sum('total_discount'),
            'total_grand' => $invoices->sum('grand_total'),
            'total_advance' => $invoices->sum('advance_payment'),
            'total_due' => $invoices->sum('total_due'),
        ];

        $html = view('pages/report.report', compact('invoices', 'summary'))->render();

        $report_pdf = view('pages/report.report_pdf', compact('invoices', 'summary'))->render();



        Session::put('report_statement', $report_pdf);
        return response()->json([
            'error' => 0,
            'message' => 'Report data fetched successfully.',
            'html' => $html
        ]);
    }




    public function downloadReport(Request $request)
    {


        $data['statement'] =  Session::get('report_statement');
        // Load the PDF view (create a separate Blade view for PDF formatting)
        $pdf = Pdf::loadView('pages/report.statement', compact('data'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('invoice_report.pdf');
    }

    public function parseDateRange($dateTimeRange)
    {
        // Split the range into start and end parts
        [$start, $end] = explode(" - ", $dateTimeRange);
        // Return the separated values as an array or JSON response
        return [
            'start_date' => $start,
            'end_date' => $end,
        ];
    }

    function convertToUTC($dateTime, $timezone = 'Asia/Kolkata')
    {

        return Carbon::createFromFormat('Y-m-d', $dateTime, $timezone)

            ->setTimezone('UTC')

            ->toDateTimeString();
    }
}
