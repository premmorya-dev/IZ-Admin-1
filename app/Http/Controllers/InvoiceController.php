<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\InvoiceModel;
use App\Models\PaymentModel;
use App\Models\SettingModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;


class InvoiceController extends Controller
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
            'invoice_id' => 'invoices.invoice_id',
            'invoice_number' => 'invoices.invoice_number',
            'invoice_date' => 'invoices.invoice_date',
            'due_date' => 'invoices.due_date',
            'status' => 'invoices.status',
            'sub_total' => 'invoices.sub_total',
            'total' => 'invoices.total',
            'created_at' => 'invoices.created_at',
            'updated_at' => 'invoices.updated_at',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'invoices.invoice_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('invoices')
                ->select(
                    'invoices.invoice_id',
                )->leftJoin('clients', 'invoices.client_id', 'clients.client_id');



            // **Applying Filters**


            if ($request->filled('invoice_number')) {
                $query->where('invoices.invoice_number', 'Like', "%" . $request->input('invoice_number') . "%");
            }

            if ($request->filled('client_name')) {
                $query->where('clients.client_name', 'Like', "%" . $request->input('client_name') . "%");
            }

            if ($request->filled('company_name')) {
                $query->where('clients.company_name', 'Like', "%" . $request->input('company_name') . "%");
            }

            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('invoices.status', $status);
            }
            if ($request->filled('issue_date')) {
                $issue_date = $this->parseDateRange($request->input('issue_date'));


                $query->where('invoices.invoice_date', '>=',  $this->convertToUTC($issue_date['start_date']));
                $query->where('invoices.invoice_date', '<=',  $this->convertToUTC($issue_date['end_date']));
            }

            if ($request->filled('sub_total')) {
                $query->where('invoices.sub_total', '=', $request->input('sub_total'));
            }

            if ($request->filled('tax_total')) {
                $query->where('invoices.tax_total', '=', $request->input('tax_total'));
            }
            if ($request->filled('discount')) {
                $query->where('invoices.discount', '=', $request->input('discount'));
            }
            if ($request->filled('total')) {
                $query->where('invoices.total', '=', $request->input('total'));
            }
            if ($request->filled('currency')) {
                $query->where('invoices.currency', '=', $request->input('currency'));
            }


            $query->where('invoices.user_id', '=', Auth::id());
            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['invoice_string'] = implode(",", array_column($query, 'invoice_id'));
        } else {

            $query = DB::table('invoices')
                ->select(
                    'invoices.invoice_id',
                );

            $query->where('invoices.user_id', '=', Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['invoice_string'] = implode(",", array_column($query, 'invoice_id'));
        }




        // else {
        //     $query->orderBy('notification_job_queue.registration_id', $order_by);
        // }

        // $actual_row = $query;
        // if($request->has('filters') && $request->input('filters') == 'true' ) {
        //     $data['totalRecords'] =  $actual_row->count();
        //     $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);
        // }



        $data['invoice'] = explode(",", $data['invoice_string']);
        if (empty($data['invoice'][0])  ||  count($data['invoice'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }


        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


        if (!empty($data['invoice'])) {

            $data['invoice'] = DB::table('invoices')

                ->select(
                    'invoices.*',
                    'clients.company_name',
                    'clients.client_name',
                    'clients.client_code',

                )
                ->leftJoin('clients', 'invoices.client_id', 'clients.client_id')
                ->where('invoices.user_id', '=', Auth::id())
                ->whereIn('invoices.invoice_id', $data['invoice'])
                ->orderBy($sort, $order_by)
                ->get();





            foreach ($data['invoice'] as $key => $invoice) {


                $currency_symbol =  DB::table('currencies')->where('currency_code', $invoice->currency_code)->first();

                if (!empty($currency_symbol)) {
                    $data['invoice'][$key]->symbol = DB::table('currencies')->where('currency_code', $invoice->currency_code)->first()->currency_symbol;
                } else {
                    $data['invoice'][$key]->symbol = '';
                }



                $data['invoice'][$key]->invoice_date_utc = $invoice->invoice_date;
                $data['invoice'][$key]->invoice_date =  !empty($invoice->invoice_date) ? getTimeDateDisplay($user->time_zone_id, $invoice->invoice_date, 'Y-m-d', 'Y-m-d') : '';

                $data['invoice'][$key]->due_date_utc = $invoice->due_date;
                $data['invoice'][$key]->due_date =  !empty($invoice->due_date) ? getTimeDateDisplay($user->time_zone_id, $invoice->due_date, 'Y-m-d', 'Y-m-d') : '';


                $data['invoice'][$key]->created_at_utc = $invoice->created_at;
                $data['invoice'][$key]->created_at =  !empty($invoice->created_at) ? getTimeDateDisplay($user->time_zone_id, $invoice->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                $data['invoice'][$key]->updated_at_utc = $invoice->updated_at;
                $data['invoice'][$key]->updated_at =  !empty($invoice->updated_at) ? getTimeDateDisplay($user->time_zone_id, $invoice->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';


                $today = Carbon::now($data['timezone']->timezone); // user's timezone
                if (!empty($invoice->due_date_utc)) {
                    $dueDate = Carbon::parse($invoice->due_date_utc);

                    if ($dueDate->lt($today)) {
                        // Due date is in past
                        $data['invoice'][$key]->due_status_text = 'Due for ' . $dueDate->diffInDays($today) . ' day(s)';
                        $data['invoice'][$key]->due_type = 'overdue';
                    } elseif ($dueDate->gt($today)) {
                        // Due date is in future
                        $data['invoice'][$key]->due_status_text = 'Due in ' . $today->diffInDays($dueDate) . ' day(s)';
                        $data['invoice'][$key]->due_type = 'upcoming';
                    } else {
                        // Due date is today
                        $data['invoice'][$key]->due_status_text = 'Due today';
                        $data['invoice'][$key]->due_type = 'today';
                    }
                } else {
                    $data['invoice'][$key]->due_status_text = 'N/A';
                    $data['invoice'][$key]->due_type = 'unknown';
                }
            }
        }

        return view('pages/invoice.list', compact('data'));
    }

    public function getRecordPaymentForm(Request $request)
    {
        $data = [];

        $data =   \DB::table('invoices')
            ->leftJoin('clients', 'invoices.client_id', 'clients.client_id')
            ->where('invoices.user_id', '=', Auth::id())
            ->where('invoices.invoice_code', $request->input('invoice_code'))->first();
        return view('pages/invoice.payment', compact('data'));
    }


    public function recordPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'invoice_id' => 'required|exists:invoices,invoice_id',
                'amount' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method' => 'required|in:cash,bank,card,upi,paypal,stripe,other',
                'transaction_reference' => 'nullable|string|max:100',
                'notes' => 'nullable|string',
            ], [
                'invoice_id.required' => 'Invoice ID is required.',
                'invoice_id.exists' => 'The selected invoice does not exist.',
                'amount.required' => 'Payment amount is required.',
                'amount.numeric' => 'Amount must be a valid number.',
                'payment_date.required' => 'Payment date is required.',
                'payment_method.required' => 'Payment method is required.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            // Save the payment
            $payment = PaymentModel::create([
                'invoice_id' => $data['invoice_id'],
                'user_id' => Auth::id(),
                'amount' => $data['amount'],
                'payment_date' => $data['payment_date'],
                'payment_method' => $data['payment_method'],
                'transaction_reference' => $data['transaction_reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            // Optionally, update the invoice total_due
            $invoice = InvoiceModel::find($data['invoice_id']);
            if ($invoice) {
                $invoice->total_due = $invoice->total_due - $data['amount'];
                $invoice->advance_payment = $invoice->advance_payment + $data['amount'];

                if ($invoice->total_due <= 0) {
                    $invoice->status = 'paid';
                    $invoice->is_paid = 'Y';
                    $invoice->paid_at = Carbon::now('UTC')->format('Y-m-d H:i:s');
                }

                $invoice->save();
            }

            return response()->json([
                'error' => 0,
                'message' => 'Payment recorded successfully!',
            ]);
        } catch (\Exception $e) {
            \Log::channel('info')->error('Error while recording payment: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while recording the payment.',
            ], 500);
        }
    }
    public function create(Request $request)
    {
        $data = [];

        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = \DB::table('templates')->orderBy('template_name', 'ASC')->get();

        $data['upi_payment_id'] = \DB::table('upi_payment_id')
            ->where('user_id', Auth::id())->orderBy('upi_name', 'ASC')->get();

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



        return view('pages/invoice.add', compact('data'));
    }

    public function edit(Request $request, $invoice_code)
    {
        $data = [];

        $data['invoice'] = \DB::table('invoices')
            ->select(
                'clients.*',
                'invoices.*',
                'countries.country_name',
                'country_states.state_name',
            )
            ->leftJoin('clients', 'invoices.client_id', 'clients.client_id')
            ->leftJoin('countries', 'countries.country_id', 'clients.country_id')
            ->leftJoin('country_states', 'country_states.state_id', 'clients.state_id')
            ->where('invoices.user_id', '=', Auth::id())
            ->where('invoice_code', $invoice_code)->first();




        if (empty($data['invoice'])) {
            return abort(404);
        }

        $data['items'] = json_decode($data['invoice']->item_json, true);






        $data['client_details_html'] = '';

        $data['client_details_html'] .= !empty($data['invoice']->company_name) ? $data['invoice']->company_name . '<br>' : $data['invoice']->client_name . '<br>';

        if (!empty($data['invoice']->address_1)) {
            $data['client_details_html'] .= $data['invoice']->address_1 . '<br>';
        }
        if (!empty($data['invoice']->address_2)) {
            $data['client_details_html'] .= $data['invoice']->address_2 . '<br>';
        }

        if (!empty($data['invoice']->state_name)) {
            $data['client_details_html'] .= $data['invoice']->state_name . ', ';
        }
        if (!empty($data['invoice']->country_name)) {
            $data['client_details_html'] .= $data['invoice']->country_name . ' ';
        }
        if (!empty($data['invoice']->zip)) {
            $data['client_details_html'] .= $data['invoice']->zip;
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


        $data['recurring'] = \DB::table('recurring_invoices')
            ->where('invoice_id', $data['invoice']->invoice_id)
            ->first();


        // dd($data);
        return view('pages/invoice.edit', compact('data'));
    }

    private function generateUniqueInvoiceCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\InvoiceModel::where('invoice_code', $code)->exists());

        return $code;
    }


    public function update(Request $request)
    {



        try {
            $validator = Validator::make($request->all(), [
                'client_id' => 'required',
                'invoice_number' => 'required|string|max:255',
                'currency_code' => 'required',
                'template_id' => 'required',
                'invoice_date' => 'required|date',
                'due_date' => 'required|date',
                'item' => 'required',
            ], [
                'client_id.required' => 'Please select a client for the invoice.',
                'invoice_number.required' => 'Invoice number is required.',
                'invoice_number.max' => 'Invoice number should not exceed 255 characters.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for invoice.',
                'invoice_date.required' => 'Invoice date is required.',
                'invoice_date.date' => 'Invoice date must be a valid date.',
                'due_date.required' => 'Due date is required.',
                'due_date.date' => 'Due date must be a valid date.',
                'item.required' => 'Please select or enter the items details.',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $userId = Auth::id();

            // Fetch invoice using invoice_code and user_id
            $invoice = InvoiceModel::where('invoice_code', $request->input('invoice_code'))
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

            $upi_id = $request->input('upi_id') ?? null;

            // Update invoice fields
            $invoice->update([
                'client_id'        => $request->input('client_id'),
                'invoice_number'   => $request->input('invoice_number'),
                'invoice_date'     => $request->input('invoice_date'),
                'due_date'         => $request->input('due_date'),
                'sub_total'        => $request->input('hidden_sub_total'),
                'total_tax'        => $request->input('hidden_total_tax'),
                'total_discount'   => $request->input('hidden_total_discount'),
                'grand_total'      => $request->input('hidden_grand_total'),
                'round_off'      => $request->input('hidden_round_off'),
                'advance_payment'  => $request->input('hidden_advance_payment'),
                'total_due'        => $request->input('hidden_total_due'),
                'notes'            => $request->input('notes'),
                'terms'            => $request->input('terms'),
                'currency_code'    => $request->input('currency_code'),
                'template'         => $request->input('template'),
                'item_json'        => json_encode($itemJson),
                'upi_id'           => $upi_id,
                'template_id'      => $request->input('template_id'),
                'display_shipping_status'      => $request->input('display_shipping_status') == 'on' ? 'Y' : 'N',
            ]);


            if ($request->has('is_recurring')) {

                $recurring_data = [];
                $recurring_data['user_id'] = Auth::id();
                $recurring_data['frequency'] = $request->input('frequency');

                if (!empty($request->input('frequency')) && $request->input('frequency') == 'monthly') {
                    $recurring_data['day_of_month'] = $request->input('day_of_month');
                    $recurring_data['day_of_week'] = null;
                    $recurring_data['month_of_year'] = null;
                } elseif (!empty($request->input('frequency')) && $request->input('frequency') == 'weekly') {
                    $recurring_data['day_of_week'] = $request->input('day_of_week');
                    $recurring_data['day_of_month'] = null;
                    $recurring_data['month_of_year'] = null;
                } elseif (!empty($request->input('frequency')) && $request->input('frequency') == 'yearly') {
                    $recurring_data['month_of_year'] = $request->input('month_of_year');
                    $recurring_data['day_of_month'] = $request->input('yearly_day_of_month');
                    $recurring_data['day_of_week'] = null;
                }

                $UTC_TIME = Carbon::createFromFormat('H:i', $request->input('time_of_day'), 'Asia/Kolkata')
                    ->setTimezone('UTC')
                    ->toDateTimeString();

                $recurring_data['time_of_day'] = $UTC_TIME;
                $recurring_data['status'] = 'active';
                $recurring_data['updated_at'] = Carbon::now('UTC')->format('Y-m-d H:i:s');



                DB::table('recurring_invoices')->updateOrInsert(
                    [
                        'invoice_id' =>  $invoice->invoice_id,
                        'user_id' =>  Auth::id()

                    ],
                    $recurring_data
                );
            }


            // Optional: Send status update logic
            if ($request->has('send_status') && $request->input('send_status') == 'true') {
                $last_notification_id = DB::table('notifications')->insertGetId([
                    'user_id' => $userId,
                    'invoice_id' => $invoice->invoice_id,
                    'notification_type' => 'email',
                    'template_id' => 1,
                    'is_read' => 'N',
                    'processing_status' => 'pending',
                    'cron_start_datetime' => null,
                    'cron_end_datetime' => null,
                    'processing_log' => null,
                ]);

                if ($last_notification_id) {
                    DB::table('invoices')
                        ->where('invoice_id', $invoice->invoice_id)
                        ->update(['is_sent' => 'submitted']);
                }
            }


            if ($request->has('paid_status') && $request->input('paid_status') == 'true') {

                $payment = PaymentModel::create([
                    'invoice_id' => $invoice->invoice_id,
                    'user_id' => Auth::id(),
                    'amount' => $request->input('hidden_total_due'),
                    'payment_date' =>  Carbon::now('UTC')->format('Y-m-d'),
                    'payment_method' => 'cash',
                    'transaction_reference' => 'manual payment' ?? null,
                    'notes' => $request->input('notes') ?? null,
                ]);


                DB::table('invoices')
                    ->where('invoice_id', $invoice->invoice_id)
                    ->update([
                        'status' => 'paid',
                        'is_paid' => 'Y'
                    ]);
            }

            return response()->json([
                "error" => 0,
                "message" => "Invoice Updated Successfully!"
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('Error while updating invoice: ' . $e->getMessage());

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
                'invoice_number' => 'required|string|max:255',
                'currency_code' => 'required',
                'template_id' => 'required',
                'invoice_date' => 'required|date',
                'due_date' => 'required|date',
                'item' => 'required',

            ], [
                'client_id.required' => 'Please select a client for the invoice.',
                'invoice_number.required' => 'Invoice number is required.',
                'invoice_number.max' => 'Invoice number should not exceed 255 characters.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for invoice.',
                'invoice_date.required' => 'Invoice date is required.',
                'invoice_date.date' => 'Invoice date must be a valid date.',
                'due_date.required' => 'Due date is required.',
                'due_date.date' => 'Due date must be a valid date.',

                'item.required' => 'Please select or enter the items details.',

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
            $invoiceNumber = $request->input('invoice_number');
            $invoiceDate = $request->input('invoice_date');
            $dueDate = $request->input('due_date');
            $status = 'pending';
            $subTotal = $request->input('hidden_sub_total');
            $totalTax = $request->input('hidden_total_tax');
            $totalDiscount = $request->input('hidden_total_discount');
            $grandTotal = $request->input('hidden_grand_total');
            $advancePayment = $request->input('hidden_advance_payment');
            $totalDue = $request->input('hidden_total_due');
            $notes = $request->input('notes');
            $terms = $request->input('terms');
            $currencyCode = $request->input('currency_code');
            $template = $request->input('template');

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


            if (!empty($request->input('upi_id'))) {
                $upi_id = $request->input('upi_id');
            } else {
                $upi_id = NULL;
            }
            // Create the invoice



            $invoice = InvoiceModel::create([
                'user_id' => $userId,
                'client_id' => $clientId,
                'invoice_number' => $invoiceNumber,
                'invoice_date' => $invoiceDate,
                'due_date' => $dueDate,
                'status' => $status,
                'sub_total' => $subTotal,
                'total_tax' => $totalTax,
                'total_discount' => $totalDiscount,
                'grand_total' => $grandTotal,
                'round_off'      => $request->input('hidden_round_off'),
                'advance_payment' => $advancePayment,
                'total_due' => $totalDue,
                'notes' => $notes,
                'terms' => $terms,
                'currency_code' => $currencyCode,
                'template' => $template,
                'item_json' => json_encode($itemJson),
                'upi_id' => $upi_id,
                'invoice_code' => $this->generateUniqueInvoiceCode(),
                'template_id' => $template_id,
                'display_shipping_status'      => $request->input('display_shipping_status') == 'on' ? 'Y' : 'N',
            ]);

            // Get the last inserted ID (invoice_id)
            $lastInsertedId = $invoice->invoice_id;

            if (!empty($lastInsertedId)) {
                foreach ($itemJson as $item) {
                    if (!empty($item['item_id'])) {
                        DB::table('items')
                            ->where('user_id', Auth::id())
                            ->where('item_id', $item['item_id'])
                            ->update([
                                'stock' => DB::raw('stock - ' . $item['quantity'])
                            ]);
                    }
                }




                if ($request->has('is_recurring')) {


                    $recurring_data['invoice_id'] =  $lastInsertedId;
                    $recurring_data['user_id'] =  Auth::id();
                    $recurring_data['frequency'] =  $request->input('frequency');


                    if (!empty($request->input('frequency')) && $request->input('frequency') == 'monthly') {
                        $recurring_data['day_of_month'] =  $request->input('day_of_month');
                    } else  if (!empty($request->input('frequency')) && $request->input('frequency') == 'weekly') {
                        $recurring_data['day_of_week'] =  $request->input('day_of_week');
                    } else  if (!empty($request->input('frequency')) && $request->input('frequency') == 'yearly') {
                        $recurring_data['month_of_year'] =  $request->input('month_of_year');
                        $recurring_data['day_of_month'] =  $request->input('yearly_day_of_month');
                    }


                    $UTC_TIME = Carbon::createFromFormat('H:i', $request->input('time_of_day'), 'Asia/Kolkata')
                        ->setTimezone('UTC')
                        ->toDateTimeString();


                    $recurring_data['time_of_day'] =  $UTC_TIME;
                    $recurring_data['status'] = 'active';
                    $recurring_data['created_at'] =  Carbon::now('UTC')->format('Y-m-d H:i:s');
                    $recurring_data['updated_at'] =   Carbon::now('UTC')->format('Y-m-d H:i:s');




                    DB::table('recurring_invoices')->insert($recurring_data);
                }
            }

            if ($request->has('send_status') && $request->input('send_status') == 'true') {

                $last_notification_id = DB::table('notifications')->insertGetId([
                    'user_id' => $userId,
                    'invoice_id' => $lastInsertedId,  // This should be the invoice ID
                    'notification_type' => 'email',
                    'template_id' => 1,
                    'is_read' => 'N',
                    'processing_status' => 'pending',
                    'cron_start_datetime' => null,
                    'cron_end_datetime' => null,
                    'processing_log' => null,
                ]);

                // Check if the notification was inserted successfully and get the associated invoice_id from the notifications table
                if ($last_notification_id) {
                    // Get the invoice_id from the notification (because it should be linked)
                    $invoiceIdFromNotification = DB::table('notifications')
                        ->where('notification_id', $last_notification_id)
                        ->value('invoice_id'); // Get the invoice_id from the notification table

                    // Update the invoice's 'is_sent' status
                    if ($invoiceIdFromNotification) {
                        DB::table('invoices')->where('invoice_id', $invoiceIdFromNotification) // Use the invoice_id here
                            ->update([
                                'is_sent' => 'submitted',
                            ]);
                    }
                }
            }




            return response()->json([
                "error" => 0,
                //'download_url' => route('invoice.download', ['invoice_code' => $data['invoice_code']]),
                "message" => "Invoice Saved Successfully!"
            ]);
        } catch (ValidationException $e) {

            Log::channel('admin')->error('error while preparing invoice: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        }
    }


    public function viewModel(Request $request)
    {


        $invoice_code = $request->input('invoice_code');
        $invoice_template_id =  shortcode('invoice', $invoice_code, "{{invoice_template_id}}");

        $template =  DB::table('templates')->where('template_id', $invoice_template_id)->first();



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


        $html =  shortcode('invoice', $invoice_code, $html);

        return response()->json([
            "error" => 0,
            'html' => $html,
            "message" => "Invoice Saved Successfully!"
        ]);
    }

    public function shortcode($invoice_code)
    {

        $invoice =  getShortcode($invoice_code);
        dd($invoice);
    }

    public function downloadMultiple(Request $request)
    {
        $invoices_code = $request->invoices_code;

        if (empty($invoices_code) || !is_array($invoices_code)) {
            return back()->with('error', 'No invoices selected.');
        }

        $zipFileName = 'invoices_' . time() . '.zip';
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {

            foreach ($invoices_code as $invoice_code) {

                // Fetch invoice
                $invoice = DB::table('invoices')
                    ->select('invoice_code')
                    ->where('invoice_code', $invoice_code)
                    ->where('invoices.user_id', '=', Auth::id())
                    ->first();

                if (!$invoice) continue;

                $invoice_code = $invoice->invoice_code;

                // Extract template ID from shortcode
                $invoice_template_id = shortcode('invoice', $invoice_code, "{{invoice_template_id}}");

                // Fetch template
                $template = DB::table('templates')->where('template_id', $invoice_template_id)->first();
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

                $html = shortcode('invoice', $invoice_code, $html);

                // Generate PDF content
                $pdf = Pdf::loadHTML($html)
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);
                $pdfContent = $pdf->output();

                // Ensure unique filename in zip
                $fileName = $invoice_code . '.pdf';
                if ($zip->locateName($fileName) !== false) {
                    $fileName = $invoice_code . '_' . uniqid() . '.pdf';
                }

                $zip->addFromString($fileName, $pdfContent);
            }

            $zip->close();
        } else {
            return back()->with('error', 'Unable to create ZIP file.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }



    public function invoiceDownload(Request $request, $invoice_code)
    {


        $invoice_template_id =  shortcode('invoice', $invoice_code, "{{invoice_template_id}}");

        $template =  DB::table('templates')->where('template_id', $invoice_template_id)->first();



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


        $html =  shortcode('invoice', $invoice_code, $html);
        // dd($html);
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        if ($request->input('preview') === 'true') {
            return $pdf->stream($invoice_code . '.pdf', ["Attachment" => false]);
        } else {
            return $pdf->download(time() . '_' . $invoice_code . '.pdf');
        }
    }


    public function bulkDelete(Request $request)
    {


        $request->validate([
            'invoices_code' => 'required|array',
            'invoices_code.*' => 'exists:invoices,invoice_code',
        ]);

        try {


            InvoiceModel::whereIn('invoice_code', $request->invoices_code)
                ->where('user_id', auth()->id()) // Ensures only current user's invoices are deleted
                ->delete();
            session()->flash('success', 'Invoices deleted successfully!');
            return response()->json([
                'error' => 0,
                'message' => 'Invoices deleted successfully.'
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'Invoices deleted failed!');
            return response()->json([
                'error' => 1,
                'message' => 'Error deleting invoices: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {

        try {

            InvoiceModel::where('invoice_code', $request->invoice_code)
                ->where('user_id', auth()->id())
                ->delete();


            session()->flash('status', 'Invoice deleted successfully!');
            return response()->json([
                'error' => 0,
                'message' => 'Invoice deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 1,
                'message' => 'Error deleting invoices: ' . $e->getMessage()
            ]);
        }
    }




    public function queueEmail(Request $request)
    {
        $invoices_code = $request->input('invoices_code');
        $userId = auth()->id();

        foreach ($invoices_code as $invoice_code) {
            $invoice =  DB::table('invoices')->where('invoice_code', $invoice_code)->first();


            DB::table('notifications')->insert([
                'user_id' => $userId,
                'invoice_id' => $invoice->invoice_id,
                'invoice_code' => $invoice_code,
                'notification_type' => 'email',
                'template_id' => 1,
                'is_read' => 'N',
                'processing_status' => 'pending',
                'cron_start_datetime' => null,
                'cron_end_datetime' => null,
                'processing_log' => null,
            ]);
            DB::table('invoices')->where([
                'user_id' => $userId,
                'invoice_code' => $invoices_code,
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

            ->toDateTimeString();
    }
}
