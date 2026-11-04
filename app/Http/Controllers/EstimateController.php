<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\EstimateModel;
use App\Models\SettingModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;

use App\Services\EstimateService;
use App\Services\InvoiceService;
use Illuminate\Validation\Rule;
use App\Services\Invoice\DocumentSequenceService;
use App\Services\Estimate\EstimateService as EstimateModuleService;
use App\Services\Estimate\EstimateShareService;

use Illuminate\Support\Facades\Cache;


class EstimateController extends Controller
{

    public function __construct(
        protected DocumentSequenceService $documentSequenceService
    ) {}



    public function index(Request $request)
    {
        $userId = Auth::id();

        /* ------------------------------------------------------------------
     | 1. Pagination (never trust a client supplied page size)
     |    The filter UI offers 50..1000, default is 10.
     * ----------------------------------------------------------------- */
        $limit = (int) $request->input('pagination_per_page', 10);
        if (!in_array($limit, [10, 50, 100, 200, 500, 1000], true)) {
            $limit = 10;
        }

        $page = max(1, (int) $request->input('page', 1));

        $data['page']    = $page;
        $data['perPage'] = $limit;
        $data['offset']  = ($page - 1) * $limit;

        // Build "?a=b&c=d&page=" safely. The old code produced "?a=b?page=" whenever a
        // query string existed without `filters`/`direction` (e.g. only pagination_per_page).
        $queryParams = $request->query();
        unset($queryParams['page']);
        $queryString = http_build_query($queryParams);
        $data['pagination_url'] = url()->current() . '?' . ($queryString !== '' ? $queryString . '&' : '') . 'page=';

        /* ------------------------------------------------------------------
     | 2. Sorting (whitelisted, direction validated)
     * ----------------------------------------------------------------- */
        $sortable = [
            'estimate_id'     => 'estimates.estimate_id',
            'estimate_number' => 'estimates.estimate_number',
            'issue_date'      => 'estimates.issue_date',
            'expiry_date'     => 'estimates.expiry_date',
            'status'          => 'estimates.status',
            'grand_total'     => 'estimates.grand_total', // the list page has a "Total" sort link
        ];

        $sortKey    = $request->input('sort');
        $sortColumn = (is_string($sortKey) && isset($sortable[$sortKey])) ? $sortable[$sortKey] : 'estimates.estimate_id';
        $direction  = strtolower((string) $request->input('direction', 'desc')) === 'asc' ? 'asc' : 'desc';

        /* ------------------------------------------------------------------
     | 3. One base query, filters applied once (no clients join needed here)
     * ----------------------------------------------------------------- */
        $base = DB::table('estimates')->where('estimates.user_id', $userId);

        if ($request->has('filters')) {
            if ($request->filled('estimate_number')) {
                $base->where('estimates.estimate_number', 'like', '%' . $request->input('estimate_number') . '%');
            }

            if ($request->filled('status')) {
                $status = array_filter(explode(',', (string) $request->input('status')));
                if ($status) {
                    $base->whereIn('estimates.status', $status);
                }
            }

            if ($request->filled('issue_date')) {
                $issue_date = $this->parseDateRange($request->input('issue_date'));

                $base->where('estimates.issue_date', '>=', $this->convertToUTC($issue_date['start_date']));
                $base->where('estimates.issue_date', '<=', $this->convertToUTC($issue_date['end_date']));
            }
        }

        $total = (clone $base)->count();

        $data['totalRecords'] = $total;
        $data['totalPages']   = (int) ceil($total / $limit);

        /* ------------------------------------------------------------------
     | 4. Fetch only the ids of the current page (index-only scan), with a
     |    tie-breaker so the page is deterministic.
     * ----------------------------------------------------------------- */
        $ids = [];

        if ($total > 0 && $data['offset'] < $total) {
            $idQuery = (clone $base)->orderBy($sortColumn, $direction);

            if ($sortColumn !== 'estimates.estimate_id') {
                $idQuery->orderBy('estimates.estimate_id', $direction);
            }

            $ids = $idQuery
                ->offset($data['offset'])
                ->limit($limit)
                ->pluck('estimates.estimate_id')
                ->all();
        }

        $data['estimate_string'] = implode(',', $ids);
        $data['show_pagination'] = !empty($ids);

        /* ------------------------------------------------------------------
     | 5. Lookups that were queried again and again -> cached / read once
     * ----------------------------------------------------------------- */
        $timeZoneId = Auth::user()->time_zone_id;

        $data['timezone'] = Cache::remember(
            'time_zone:' . $timeZoneId,
            now()->addDay(),
            fn() => DB::table('time_zone')->where('time_zone_id', $timeZoneId)->first()
        );

        // small table: one cached map instead of 2 queries per row
        $currencySymbols = Cache::remember(
            'currency_symbols',
            now()->addDay(),
            fn() => DB::table('currencies')->pluck('currency_symbol', 'currency_code')->all()
        );

        /* ------------------------------------------------------------------
     | 6. Load full rows for just this page (skipped completely when empty)
     * ----------------------------------------------------------------- */
        $estimates = collect();

        if (!empty($ids)) {
            $rows = DB::table('estimates')
                ->select(
                    'estimates.*',
                    'clients.company_name',
                    'clients.client_name',
                    'clients.client_code'
                )
                ->leftJoin('clients', 'estimates.client_id', '=', 'clients.client_id')
                ->where('estimates.user_id', $userId)
                ->whereIn('estimates.estimate_id', $ids)
                ->get();

            // keep the order produced by the id query (no second ORDER BY / filesort)
            $position  = array_flip($ids);
            $estimates = $rows->sortBy(fn($row) => $position[$row->estimate_id])->values();

            $estimates->transform(function ($estimate) use ($currencySymbols, $timeZoneId) {
                $estimate->symbol = $currencySymbols[$estimate->currency_code] ?? '';

                $estimate->issue_date_utc = $estimate->issue_date;
                $estimate->issue_date = !empty($estimate->issue_date)
                    ? getTimeDateDisplay($timeZoneId, $estimate->issue_date, 'Y-m-d', 'Y-m-d') : '';

                $estimate->expiry_date_utc = $estimate->expiry_date;
                $estimate->expiry_date = !empty($estimate->expiry_date)
                    ? getTimeDateDisplay($timeZoneId, $estimate->expiry_date, 'Y-m-d', 'Y-m-d') : '';

                $estimate->created_at_utc = $estimate->created_at;
                $estimate->created_at = !empty($estimate->created_at)
                    ? getTimeDateDisplay($timeZoneId, $estimate->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                $estimate->updated_at_utc = $estimate->updated_at;
                $estimate->updated_at = !empty($estimate->updated_at)
                    ? getTimeDateDisplay($timeZoneId, $estimate->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                return $estimate;
            });
        }

        $data['estimate'] = $estimates;

        return view('pages/estimate.list', compact('data'));
    }


    public function create(Request $request, EstimateModuleService $estimateService)
    {

        $data = $estimateService->getCreateData();

        return view('pages/estimate.add', compact('data'));
    }

    public function edit(Request $request, $estimate_code, EstimateModuleService $estimateService)
    {

        $data = $estimateService->getEditData($estimate_code);

        if (empty($data)) {
            return abort(404);
        }

        return view('pages/estimate.edit', compact('data'));
    }

    public function convertToInvoice(Request $request, $estimate_code, EstimateModuleService $estimateService)
    {

        $data = $estimateService->getEditData($estimate_code);
        if (empty($data)) {
            return abort(404);
        }

        return view('pages/estimate.convert_to_invoice', compact('data'));
    }

    private function generateUniqueestimateCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\EstimateModel::where('estimate_code', $code)->exists());

        return $code;
    }


    public function update(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'estimate_number' => [
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('estimates', 'estimate_number')
                        ->ignore($request->estimate_code, 'estimate_code'),
                ],
                'currency_code' => 'required',
                'template_id' => 'required',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date',
            ], [
                'client_id.required' => 'Please select a client for the estimate.',
                'estimate_number.required' => 'estimate number is required.',
                'estimate_number.max' => 'estimate number should not exceed 255 characters.',
                'estimate_number.unique' => 'This estimate number already exists. Please use a different number.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for estimate.',
                'issue_date.required' => 'estimate date is required.',
                'issue_date.date' => 'estimate date must be a valid date.',
                'expiry_date.required' => 'Due date is required.',
                'expiry_date.date' => 'Due date must be a valid date.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $userId = Auth::id();

            // Fetch estimate using estimate_code and user_id
            $estimate = EstimateModel::where('estimate_code', $request->input('estimate_code'))
                ->where('user_id', $userId)
                ->firstOrFail();

            $itemJson = $request->input('item');
            $fieldsToClean = ['rate', 'discount', 'tax', 'amount'];

            if (!empty($itemJson)) {
                foreach ($itemJson as $index => $item) {
                    foreach ($fieldsToClean as $field) {
                        if (isset($item[$field])) {
                            $itemJson[$index][$field] = preg_replace('/[^\d.]/', '', $item[$field]);
                        }
                    }
                }
            }

            if (is_string($itemJson)) {
                $itemJson = json_decode($itemJson, true);
            }


            // Update estimate fields
            $estimate->update([
                'client_id'        => $request->input('client_id'),
                'estimate_number'   => $request->input('estimate_number'),
                'issue_date'     => $request->input('issue_date'),
                'expiry_date'         => $request->input('expiry_date'),
                'sub_total'        => $request->input('hidden_sub_total'),

                'taxable_value'        => $request->input('hidden_total_taxable'),
                'cgst_amount'        => $request->input('hidden_total_cgst'),
                'sgst_amount'        => $request->input('hidden_total_sgst'),
                'igst_amount'        => $request->input('hidden_total_igst'),


                'total_tax'        => $request->input('hidden_total_tax'),
                'total_discount'   => $request->input('hidden_total_discount'),
                'grand_total'      => $request->input('hidden_grand_total'),
                'round_off'      => $request->input('hidden_round_off'),

                'notes'            => $request->input('notes'),
                'upi_id'            => $request->input('upi_id_payment_status') == 'on' ? $request->input('upi_id') : NULL,
                'terms'            => $request->input('terms'),
                'currency_code'    => $request->input('currency_code'),
                'item_json'        => json_encode($itemJson),
                'template_id'      => $request->input('template_id'),
                'display_shipping_status'      => $request->input('display_shipping_status') == 'on' ? 'Y' : 'N',
            ]);

            // Optional: Send status update logic
            if ($request->has('send_status') && $request->input('send_status') == 'true') {
                $last_notification_id = DB::table('estimate_notifications')->insertGetId([
                    'user_id' => $userId,
                    'estimate_id' => $estimate->estimate_id,
                    'notification_type' => 'email',
                    'template_id' => $request->input('template_id'),
                    'is_read' => 'N',
                    'processing_status' => 'pending',
                    'cron_start_datetime' => null,
                    'cron_end_datetime' => null,
                    'processing_log' => null,
                ]);

                if ($last_notification_id) {
                    DB::table('estimates')
                        ->where('estimate_id', $estimate->estimate_id)
                        ->update(['is_sent' => 'submitted']);
                }
            }
            if ($request->has('estimate_accept') && $request->input('estimate_accept') == 'true') {
                DB::table('estimates')->where('estimate_id', $estimate->estimate_id) // Use the estimate_id here
                    ->update([
                        'status' => 'accepted',
                    ]);
            }

            return response()->json([
                "error" => 0,
                "message" => "Estimate Updated Successfully!"
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('Error while updating estimate: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        }
    }




    public function store(Request $request)
    {

        try {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'estimate_number' => 'required|string|max:255|unique:estimates,estimate_number',
                'currency_code' => 'required',
                'template_id' => 'required',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date',
            ], [
                'client_id.required' => 'Please select a client for the estimate.',
                'estimate_number.required' => 'estimate number is required.',
                'estimate_number.max' => 'estimate number should not exceed 255 characters.',
                'estimate_number.unique' => 'This estimate number already exists. Please use a different number.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for estimate.',
                'issue_date.required' => 'estimate date is required.',
                'issue_date.date' => 'estimate date must be a valid date.',
                'expiry_date.required' => 'Due date is required.',
                'expiry_date.date' => 'Due date must be a valid date.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();
            // Retrieve data from the request
            $userId = Auth::id();
            $clientId = $request->input('client_id');
            $estimateNumber = $request->input('estimate_number');
            $issueDate = $request->input('issue_date');
            $expiryDate = $request->input('expiry_date');
            $status = 'draft';
            $subTotal = $request->input('hidden_sub_total');
            $totalTax = $request->input('hidden_total_tax');
            $totalDiscount = $request->input('hidden_total_discount');
            $grandTotal = $request->input('hidden_grand_total');
            $notes = $request->input('notes');
            $terms = $request->input('terms');
            $currencyCode = $request->input('currency_code');
            $notes = $request->input('notes');
            $terms = $request->input('terms');
            $template_id = $request->input('template_id');

            $itemJson = $request->input('item'); // Get the item_json field (can be a string or array)

            // Fields where you want to remove currency symbols
            $fieldsToClean = ['rate', 'discount', 'tax', 'amount'];

            if (!empty($itemJson)) {
                foreach ($itemJson as $index => $item) {
                    foreach ($fieldsToClean as $field) {
                        if (isset($item[$field])) {
                            // Remove everything except numbers and decimal points
                            $itemJson[$index][$field] = preg_replace('/[^\d.]/', '', $item[$field]);
                        }
                    }
                }
            }



            // If item_json is a string, decode it into an array (if not already an array)
            if (is_string($itemJson)) {
                $itemJson = json_decode($itemJson, true);
            }



            $estimate = EstimateModel::create([
                'user_id' => $userId,
                'client_id' => $clientId,
                'estimate_number' => $estimateNumber,
                'issue_date' => $issueDate,
                'expiry_date' => $expiryDate,
                'status' => $status,
                'taxable_value'        => $request->input('hidden_total_taxable'),
                'cgst_amount'        => $request->input('hidden_total_cgst'),
                'sgst_amount'        => $request->input('hidden_total_sgst'),
                'igst_amount'        => $request->input('hidden_total_igst'),
                'round_off'      => $request->input('hidden_round_off'),
                'sub_total' => $subTotal,
                'total_tax' => $totalTax,
                'total_discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'notes' => $notes,
                'terms' => $terms,
                'currency_code' => $currencyCode,
                'item_json' => json_encode($itemJson),
                'estimate_code' => $this->generateUniqueestimateCode(),
                'template_id' => $template_id,
                'display_shipping_status'      => $request->input('display_shipping_status') == 'on' ? 'Y' : 'N',
                'upi_id'            => $request->input('upi_id_payment_status') == 'on' ? $request->input('upi_id') : NULL,
            ]);

            // Get the last inserted ID (estimate_id)
            $lastInsertedId = $estimate->estimate_id;

            $this->documentSequenceService->generate(auth()->id(), 'estimate');

            if ($request->has('send_status') && $request->input('send_status') == 'true') {

                $last_notification_id = DB::table('estimate_notifications')->insertGetId([
                    'user_id' => $userId,
                    'estimate_id' => $lastInsertedId,  // This should be the estimate ID
                    'notification_type' => 'email',
                    'template_id' => $template_id,
                    'is_read' => 'N',
                    'processing_status' => 'pending',
                    'cron_start_datetime' => null,
                    'cron_end_datetime' => null,
                    'processing_log' => null,
                ]);

                // Check if the notification was inserted successfully and get the associated estimate_id from the estimate_notifications table
                if ($last_notification_id) {
                    // Get the estimate_id from the notification (because it should be linked)
                    $estimateIdFromNotification = DB::table('estimate_notifications')
                        ->where('notification_id', $last_notification_id)
                        ->value('estimate_id'); // Get the estimate_id from the notification table

                    // Update the estimate's 'is_sent' status
                    if ($estimateIdFromNotification) {
                        DB::table('estimates')->where('estimate_id', $estimateIdFromNotification) // Use the estimate_id here
                            ->update([
                                'is_sent' => 'submitted',
                            ]);
                    }
                }
            }


            if (!empty($lastInsertedId) &&  $request->has('estimate_accept') && $request->input('estimate_accept') == 'true') {
                DB::table('estimates')->where('estimate_id', $lastInsertedId) // Use the estimate_id here
                    ->update([
                        'status' => 'accepted',
                    ]);
            }



            return response()->json([
                "error" => 0,
                //'download_url' => route('estimate.download', ['estimate_code' => $data['estimate_code']]),
                "message" => "estimate Saved Successfully!"
            ]);
        } catch (ValidationException $e) {

            Log::channel('admin')->error('error while preparing estimate: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        }
    }
    public function estimateAcceptance(Request $request, $estimate_code)
    {

        // https://pro.invoicezy.com/estimate/acceptance/a80ed6a59745ad7f2cf5e5c9eb6c4614c0211a2de6941a3223aeb9fa0021fd3c?acceptance=true
        $data = [];
        $acceptance = $request->input('acceptance');
        $data['message'] = 'Estimate not found.';
        $estimate =  DB::table('estimates')->where('estimate_code', $estimate_code)->first();

        if (!$estimate) {
            $data['success'] = false;
            return response()->json($data, 404);
        }

        // Step 3: Update the status to 'accepted'

        if ($acceptance && $acceptance == 'true') {
            DB::table('estimates')
                ->where('estimate_code', $estimate_code)
                ->update(['status' => 'accepted']);
            $data['message'] = 'Estimate marked as accepted.';
            $data['success'] = true;
            $data['accepted'] = true;
        } else {
            DB::table('estimates')
                ->where('estimate_code', $estimate_code)
                ->update(['status' => 'rejected']);
            $data['message'] = 'Estimate marked as rejected.';
            $data['success'] = true;
            $data['accepted'] = false;
        }



        return view('pages/estimate.acceptance', compact('data'));
    }


    public function viewModel(Request $request)
    {


        $estimate_code = $request->input('estimate_code');
        $estimate_template_id =  shortcode('estimate', $estimate_code, "{{estimate_template_id}}");

        $template =  DB::table('estimate_templates')->where('template_id', $estimate_template_id)->first();

        $display_shipping_status = shortcode('estimate', $estimate_code, '{{display_shipping_status}}');

        if ($display_shipping_status == 'N') {
            $template_content = preg_replace('/\{\{#shipping\}\}.*?\{\{\/shipping\}\}/s', '', $template->content);
        } else {
            $template_content = str_replace(
                ['{{#shipping}}', '{{/shipping}}'],
                '',
                $template->content
            );
        }
        $html = $this->cleanHtml((string) ($template_content ?? ''));


        $html =  shortcode('estimate', $estimate_code, $html);

        return response()->json([
            "error" => 0,
            'html' => $html,
            "message" => "Estimate Saved Successfully!"
        ]);
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

    public function shortcode($estimate_code)
    {

        $estimate =  getShortcode($estimate_code);
        dd($estimate);
    }

    public function downloadMultiple(Request $request)
    {
        $estimates_code = $request->estimates_code;

        if (empty($estimates_code) || !is_array($estimates_code)) {
            return back()->with('error', 'No estimates selected.');
        }

        $zipFileName = 'estimates_' . time() . '.zip';
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {

            foreach ($estimates_code as $estimate_code) {

                // Fetch estimate
                $estimate = DB::table('estimates')
                    ->select('estimate_code')
                    ->where('estimate_code', $estimate_code)
                    ->where('estimates.user_id', '=', Auth::id())
                    ->first();

                if (!$estimate) continue;

                $estimate_code = $estimate->estimate_code;

                // Extract template ID from shortcode
                $estimate_template_id = shortcode('estimate', $estimate_code, "{{estimate_template_id}}");

                // Fetch template
                $template = DB::table('estimate_templates')->where('template_id', $estimate_template_id)->first();
                if (!$template) continue;

                // Clean and parse template HTML
                $html = preg_replace([
                    '/\>[^\S ]+/s',
                    '/[^\S ]+\</s',
                    '/(\s)+/s',
                    '/<!--(.|\s)*?-->/'
                ], ['>', '<', '\\1', ''], $template->content);

                $html = preg_replace([
                    '/>\s+</',
                    '/\s{2,}/',
                    '/<!--(.*?)-->/'
                ], ['><', ' ', ''], $html);

                $html = shortcode('estimate', $estimate_code, $html);

                // Generate PDF content
                $pdf = Pdf::loadHTML($html)
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);
                $pdfContent = $pdf->output();

                // Ensure unique filename in zip
                $fileName = $estimate_code . '.pdf';
                if ($zip->locateName($fileName) !== false) {
                    $fileName = $estimate_code . '_' . uniqid() . '.pdf';
                }

                $zip->addFromString($fileName, $pdfContent);
            }

            $zip->close();
        } else {
            return back()->with('error', 'Unable to create ZIP file.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function estimateDownload(Request $request, $estimate_code)
    {

        $user  = DB::table('estimates')->where('estimate_code', $estimate_code)->select('user_id')->first();

        $estimate_template_id =  shortcode('estimate', $estimate_code, "{{estimate_template_id}}",  $user->user_id);
        $template =  DB::table('estimate_templates')->where('template_id', $estimate_template_id)->first();

        $display_shipping_status = shortcode('estimate', $estimate_code, '{{display_shipping_status}}', $user->user_id);

        if ($display_shipping_status == 'N') {
            $template_content = preg_replace('/\{\{#shipping\}\}.*?\{\{\/shipping\}\}/s', '', $template->content);
        } else {
            $template_content = str_replace(
                ['{{#shipping}}', '{{/shipping}}'],
                '',
                $template->content
            );
        }
        $html = $this->cleanHtml((string) ($template_content ?? ''));

        $html =  shortcode('estimate', $estimate_code, $html, $user->user_id);

        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        if ($request->input('preview') === 'true') {
            return $pdf->stream($estimate_code . '.pdf', ["Attachment" => false]);
        } else {
            return $pdf->download(time() . '_' . $estimate_code . '.pdf');
        }
    }

    public function shareWhatsapp($estimate_code, EstimateShareService $shareService)
    {
        $estimate = EstimateModel::where('estimate_code', $estimate_code)->firstOrFail();

        $publicUrl = $shareService->generatePublicLink($estimate);

        $url = $shareService->sendWhatsAppEstimate($estimate);

        return $url;
    }

    public function estimateDownloadSecureLink(Request $request, $share_token)
    {
        $estimate = EstimateModel::where('share_token', $share_token,)
            ->where(function ($q) {
                $q->whereNull('public_link_expires_at')
                    ->orWhere('public_link_expires_at', '>', now());
            })
            ->firstOrFail();

        return  $this->estimateDownload($request, $estimate->estimate_code);
    }

    public function bulkDelete(Request $request)
    {


        $request->validate([
            'estimates_code' => 'required|array',
            'estimates_code.*' => 'exists:estimates,estimate_code',
        ]);

        try {


            EstimateModel::whereIn('estimate_code', $request->estimates_code)
                ->where('user_id', auth()->id()) // Ensures only current user's estimates are deleted
                ->delete();
            session()->flash('success', 'Estimates deleted successfully!');
            return response()->json([
                'error' => 0,
                'message' => 'Estimates deleted successfully.'
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Estimates deleted failed!');
            return response()->json([
                'error' => 1,
                'message' => 'Error deleting estimates: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {

        try {

            EstimateModel::where('estimate_code', $request->estimate_code)
                ->where('user_id', auth()->id())
                ->delete();


            session()->flash('status', 'Estimate deleted successfully!');
            return response()->json([
                'error' => 0,
                'message' => 'Estimate deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 1,
                'message' => 'Error deleting estimates: ' . $e->getMessage()
            ]);
        }
    }




    public function queueEmail(Request $request)
    {
        $estimates_code = $request->input('estimates_code');
        $userId = auth()->id();
        $queued = 0;
        try {
            foreach ($estimates_code as $estimate_code) {
                $estimate =  DB::table('estimates')->where('estimate_code', $estimate_code)->first();


                DB::table('estimate_notifications')->insert([
                    'user_id' => $userId,
                    'estimate_id' => $estimate->estimate_id,
                    'estimate_code' => $estimate_code,
                    'notification_type' => 'email',
                    'template_id' => 1,
                    'is_read' => 'N',
                    'processing_status' => 'pending',
                    'cron_start_datetime' => null,
                    'cron_end_datetime' => null,
                    'processing_log' => null,
                ]);
                DB::table('estimates')->where([
                    'user_id' => $userId,
                    'estimate_code' => $estimates_code,
                ])->update([
                    'is_sent' => 'submitted',
                ]);

                $queued++;
            }


            if ($queued > 0) {
                session()->flash('success', 'Email queued successfully.');
            } else {
                session()->flash('warning', 'No Estimate were queued.');
            }

            $result =  [
                'status' => 200,
                'error' => $queued > 0 ? 0 : 1,
                'message' => $queued > 0 ? 'Email queued successfully.' : 'No estimate were queued.',
                'queued' => $queued,
            ];
        } catch (\Exception $e) {
            logger()->error('Estimate email queue failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            $result = [
                'status' => 500,
                'error' => 1,
                'message' => 'Something went wrong while queueing emails.',
            ];
        }

        return response()->json($result, 200);
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

    public function parseDateTimeRange($dateTimeRange)
    {
        // Split the range into start and end parts
        [$start, $end] = explode(" - ", $dateTimeRange);

        // Parse start date and time
        $startDateTime = explode(" ", $start);
        $startDate = $startDateTime[0]; // Start Date
        $startTime = $startDateTime[1]; // Start Time

        // Parse end date and time
        $endDateTime = explode(" ", $end);
        $endDate = $endDateTime[0]; // End Date
        $endTime = $endDateTime[1]; // End Time

        // Return the separated values as an array or JSON response
        return [
            'start_date' => $startDate,
            'start_time' => $startTime,
            'end_date' => $endDate,
            'end_time' => $endTime,
            'start_date_time' => $startDate . " " .  $startTime,
            'end_date_time' => $endDate . " " .  $endTime,
        ];
    }

    function convertToUTC($dateTime, $timezone = 'Asia/Kolkata')
    {

        return Carbon::createFromFormat('Y-m-d', $dateTime, $timezone)

            ->setTimezone('UTC')

            ->format('Y-m-d');
    }
}
