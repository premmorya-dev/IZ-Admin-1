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


class EstimateController extends Controller
{
    public function index(Request $request)
    {



        if ($request->filled('pagination_per_page')) {
            $limit = $request->input('pagination_per_page');
        } else {
            $limit = 10;
        }

        $data['page'] = request()->get('page', 1);
        $data['perPage'] = $limit;
        $data['offset'] = ($data['page']  - 1) * $data['perPage'];

        $queryParams = $request->query();
        unset($queryParams['page']);
        $newQueryString = http_build_query($queryParams);

        if (($request->has('filters') && $request->input('filters') == 'true') ||  $request->has('direction')) {
            $data['pagination_url'] = url()->current() . (!empty($newQueryString) ? '?' . $newQueryString : '') .  '&page=';
        } else {
            $data['pagination_url'] = url()->current() . (!empty($newQueryString) ? '?' . $newQueryString : '') . '?page=';
        }


        //pagination

        // sorting
        $sort_by = [
            'estimate_id' => 'estimates.estimate_id',
            'estimate_number' => 'estimates.estimate_number',
            'issue_date' => 'estimates.issue_date',
            'expiry_date' => 'estimates.expiry_date',
            'expiry_date' => 'estimates.expiry_date',
            'status' => 'estimates.status',
            'total' => 'estimates.total',
            'grand_total' => 'estimates.grand_total',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'estimates.estimate_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('estimates')
                ->select(
                    'estimates.estimate_id',
                )->leftJoin('clients', 'estimates.client_id', 'clients.client_id');



            // **Applying Filters**


            if ($request->filled('estimate_number')) {
                $query->where('estimates.estimate_number', 'Like', "%" . $request->input('estimate_number') . "%");
            }



            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('estimates.status', $status);
            }
            if ($request->filled('issue_date')) {
                $issue_date = $this->parseDateRange($request->input('issue_date'));


                $query->where('estimates.issue_date', '>=',  $this->convertToUTC($issue_date['start_date']));
                $query->where('estimates.issue_date', '<=',  $this->convertToUTC($issue_date['end_date']));
            }

            if ($request->filled('sub_total')) {
                $query->where('estimates.sub_total', '=', $request->input('sub_total'));
            }

            if ($request->filled('tax_total')) {
                $query->where('estimates.tax_total', '=', $request->input('tax_total'));
            }
            if ($request->filled('total_discount')) {
                $query->where('estimates.total_discount', '=', $request->input('total_discount'));
            }
            if ($request->filled('grand_total')) {
                $query->where('estimates.grand_total', '=', $request->input('grand_total'));
            }
            if ($request->filled('currency')) {
                $query->where('estimates.currency', '=', $request->input('currency'));
            }


            $query->where('estimates.user_id', '=', Auth::id());
            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['estimate_string'] = implode(",", array_column($query, 'estimate_id'));
        } else {

            $query = DB::table('estimates')
                ->select(
                    'estimates.estimate_id',
                );

            $query->where('estimates.user_id', '=', Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['estimate_string'] = implode(",", array_column($query, 'estimate_id'));
        }


        $data['estimate'] = explode(",", $data['estimate_string']);
        if (empty($data['estimate'][0])  ||  count($data['estimate'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }


        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();




        if (!empty($data['estimate'])) {

            $data['estimate'] = DB::table('estimates')

                ->select(
                    'estimates.*',
                    'clients.company_name',
                    'clients.client_name',
                    'clients.client_code',

                )
                ->leftJoin('clients', 'estimates.client_id', 'clients.client_id')
                ->where('estimates.user_id', '=', Auth::id())
                ->whereIn('estimates.estimate_id', $data['estimate'])
                ->orderBy($sort, $order_by)
                ->get();


            foreach ($data['estimate'] as $key => $estimate) {


                $currency_symbol =  DB::table('currencies')->where('currency_code', $estimate->currency_code)->first();

                if (!empty($currency_symbol)) {
                    $data['estimate'][$key]->symbol = DB::table('currencies')->where('currency_code', $estimate->currency_code)->first()->currency_symbol;
                } else {
                    $data['estimate'][$key]->symbol = '';
                }



                $data['estimate'][$key]->issue_date_utc = $estimate->issue_date;
                $data['estimate'][$key]->issue_date =  !empty($estimate->issue_date) ? getTimeDateDisplay($user->time_zone_id, $estimate->issue_date, 'Y-m-d', 'Y-m-d') : '';

                $data['estimate'][$key]->expiry_date_utc = $estimate->expiry_date;
                $data['estimate'][$key]->expiry_date =  !empty($estimate->expiry_date) ? getTimeDateDisplay($user->time_zone_id, $estimate->expiry_date, 'Y-m-d', 'Y-m-d') : '';


                $data['estimate'][$key]->created_at_utc = $estimate->created_at;
                $data['estimate'][$key]->created_at =  !empty($estimate->created_at) ? getTimeDateDisplay($user->time_zone_id, $estimate->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                $data['estimate'][$key]->updated_at_utc = $estimate->updated_at;
                $data['estimate'][$key]->updated_at =  !empty($estimate->updated_at) ? getTimeDateDisplay($user->time_zone_id, $estimate->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            }
        }



        return view('pages/estimate.list', compact('data'));
    }


    public function create(Request $request)
    {
        $data = [];

        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = \DB::table('templates')->orderBy('template_name', 'ASC')->get();



        $data['setting'] = \DB::table('settings')->where('user_id', Auth::id())->first();
        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();


        if (!empty($data['setting'])) {
            $data['setting']->country = \DB::table('countries')->where('country_id',  $data['setting']->country_id)->first();
            $data['setting']->state = \DB::table('country_states')->where('state_id',  $data['setting']->state_id)->first();
        }



        return view('pages/estimate.add', compact('data'));
    }

    public function edit(Request $request, $estimate_code)
    {
        $data = [];

        $data['estimate'] = \DB::table('estimates')
            ->select(
                'clients.*',
                'estimates.*',
                'countries.country_name',
                'country_states.state_name',
            )
            ->leftJoin('clients', 'estimates.client_id', 'clients.client_id')
            ->leftJoin('countries', 'countries.country_id', 'clients.country_id')
            ->leftJoin('country_states', 'country_states.state_id', 'clients.state_id')
            ->where('estimates.user_id', '=', Auth::id())
            ->where('estimate_code', $estimate_code)->first();


        if (empty($data['estimate'])) {
            return abort(404);
        }

        $data['items'] = json_decode($data['estimate']->item_json, true);





        $data['client_details_html'] = '';

        $data['client_details_html'] .=  !empty($data['estimate']->company_name) ? $data['estimate']->company_name . '<br>' : $data['estimate']->client_name . '<br>';

        if (!empty($data['estimate']->address_1)) {
            $data['client_details_html'] .= $data['estimate']->address_1 . '<br>';
        }
        if (!empty($data['estimate']->address_2)) {
            $data['client_details_html'] .= $data['estimate']->address_2 . '<br>';
        }

        if (!empty($data['estimate']->state_name)) {
            $data['client_details_html'] .= $data['estimate']->state_name . ', ';
        }
        if (!empty($data['estimate']->country_name)) {
            $data['client_details_html'] .= $data['estimate']->country_name . ' ';
        }
        if (!empty($data['estimate']->zip)) {
            $data['client_details_html'] .= $data['estimate']->zip;
        }



        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = \DB::table('templates')->orderBy('template_name', 'ASC')->get();
        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['upi_payment_id'] = \DB::table('upi_payment_id')
            ->where('user_id', Auth::id())->orderBy('upi_name', 'ASC')->get();

        $data['setting'] = \DB::table('settings')->where('user_id', Auth::id())->first();

        if (!empty($data['setting'])) {
            $data['setting']->country = \DB::table('countries')->where('country_id',  $data['setting']->country_id)->first();
            $data['setting']->state = \DB::table('country_states')->where('state_id',  $data['setting']->state_id)->first();
        }


        // dd($data);
        return view('pages/estimate.edit', compact('data'));
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
                'estimate_number' => 'required|string|max:255',
                'currency_code' => 'required',
                'template_id' => 'required',
                'issue_date' => 'required|date',
                'expiry_date' => 'required|date',
            ], [
                'client_id.required' => 'Please select a client for the estimate.',
                'estimate_number.required' => 'estimate number is required.',
                'estimate_number.max' => 'estimate number should not exceed 255 characters.',
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
                'total_tax'        => $request->input('hidden_total_tax'),
                'total_discount'   => $request->input('hidden_total_discount'),
                'grand_total'      => $request->input('hidden_grand_total'),
                'notes'            => $request->input('notes'),
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
                'sub_total' => $subTotal,
                'total_tax' => $totalTax,
                'total_discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'notes' => $notes,
                'terms' => $terms,
                'currency_code' => $currencyCode,
                'item_json' => json_encode($itemJson),
                'notes' => $notes,
                'terms' => $terms,
                'estimate_code' => $this->generateUniqueestimateCode(),
                'template_id' => $template_id,
                'display_shipping_status'      => $request->input('display_shipping_status') == 'on' ? 'Y' : 'N',
            ]);

            // Get the last inserted ID (estimate_id)
            $lastInsertedId = $estimate->estimate_id;


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



        $search = [
            '/\>[^\S ]+/s',  // Remove spaces after tags, except spaces
            '/[^\S ]+\</s',  // Remove spaces before tags, except spaces
            '/(\s)+/s',       // Reduce multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        ];
        $replace = ['>', '<', '\\1', ''];
        $html = preg_replace($search, $replace, $template->content);
        $html = preg_replace(
            ['/>\s+</', '/\s{2,}/', '/<!--(.*?)-->/'],
            ['><', ' ', ''],
            $html
        );


        $html =  shortcode('estimate', $estimate_code, $html);

        return response()->json([
            "error" => 0,
            'html' => $html,
            "message" => "Estimate Saved Successfully!"
        ]);
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

        // $estimateService = new EstimateService();
        // $estimate = $estimateService->getDocumentData('EST-003');

        // $invoiceService = new InvoiceService();
        // $invoice = $invoiceService->getDocumentData('1b7c1d2027f16b7ec156e5297b51404f4c679539dbdfe2e03bf3394583a7774f');
        // $tt   = getShortcode('estimate', 'a80ed6a59745ad7f2cf5e5c9eb6c4614c0211a2de6941a3223aeb9fa0021fd3c');



        $estimate_template_id =  shortcode('estimate', $estimate_code, "{{estimate_template_id}}");

        $template =  DB::table('estimate_templates')->where('template_id', $estimate_template_id)->first();



        $search = [
            '/\>[^\S ]+/s',  // Remove spaces after tags, except spaces
            '/[^\S ]+\</s',  // Remove spaces before tags, except spaces
            '/(\s)+/s',       // Reduce multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        ];
        $replace = ['>', '<', '\\1', ''];
        $html = preg_replace($search, $replace, $template->content);
        $html = preg_replace(
            ['/>\s+</', '/\s{2,}/', '/<!--(.*?)-->/'],
            ['><', ' ', ''],
            $html
        );


        $html =  shortcode('estimate', $estimate_code, $html);

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
        }
        session()->flash('success', 'Email Queued Successfully!');
        return response()->json(['message' => 'Email Queued Successfully.']);
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
