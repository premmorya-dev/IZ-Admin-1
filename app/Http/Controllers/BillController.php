<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BillModel;
use App\Models\PaymentModel;
use App\Models\SettingModel;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;


class BillController extends Controller
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
            'bill_id' => 'bills.bill_id',
            'bill_number' => 'bills.bill_number',
            'bill_date' => 'bills.bill_date',
            'due_date' => 'bills.due_date',
            'bill_status' => 'bills.bill_status',
            'sub_total' => 'bills.sub_total',
            'total' => 'bills.total',
            'created_at' => 'bills.created_at',
            'updated_at' => 'bills.updated_at',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'bills.bill_id';
        }
        // sorting

        if ($request->has('filters')) {

            $query = DB::table('bills')
                ->select(
                    'bills.bill_id',
                )->leftJoin('vendors', 'bills.vendor_id', 'vendors.vendor_id');



            // **Applying Filters**


            if ($request->filled('bill_number')) {
                $query->where('bills.bill_number', 'Like', "%" . $request->input('bill_number') . "%");
            }

            if ($request->filled('vendor_name')) {
                $query->where('vendors.vendor_name', 'Like', "%" . $request->input('vendor_name') . "%");
            }

            if ($request->filled('company_name')) {
                $query->where('vendors.company_name', 'Like', "%" . $request->input('company_name') . "%");
            }

            if ($request->filled('bill_status')) {
                $bill_status = explode(',', $request->input('bill_status'));
                $query->whereIn('bills.bill_status', $bill_status);
            }
            if ($request->filled('due_date')) {
                $due_date = $this->parseDateRange($request->input('due_date'));


                $query->where('bills.due_date', '>=',  convertToUTCDateOnly($due_date['start_date']));
                $query->where('bills.due_date', '<=',  convertToUTCDateOnly($due_date['end_date']));
            }

            if ($request->filled('bill_date')) {
                $bill_date = $this->parseDateRange($request->input('bill_date'));


                $query->where('bills.bill_date', '>=',  convertToUTCDateOnly($bill_date['start_date']));
                $query->where('bills.bill_date', '<=',  convertToUTCDateOnly($bill_date['end_date']));
            }

            if ($request->filled('sub_total')) {
                $query->where('bills.sub_total', '=', $request->input('sub_total'));
            }

            if ($request->filled('tax_total')) {
                $query->where('bills.tax_total', '=', $request->input('tax_total'));
            }
            if ($request->filled('discount')) {
                $query->where('bills.discount', '=', $request->input('discount'));
            }
            if ($request->filled('total')) {
                $query->where('bills.total', '=', $request->input('total'));
            }
            if ($request->filled('currency')) {
                $query->where('bills.currency', '=', $request->input('currency'));
            }


            $query->where('bills.user_id', '=', Auth::id());
            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['bill_string'] = implode(",", array_column($query, 'bill_id'));
        } else {

            $query = DB::table('bills')
                ->select(
                    'bills.bill_id',
                );

            $query->where('bills.user_id', '=', Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['bill_string'] = implode(",", array_column($query, 'bill_id'));
        }




        // else {
        //     $query->orderBy('notification_job_queue.registration_id', $order_by);
        // }

        // $actual_row = $query;
        // if($request->has('filters') && $request->input('filters') == 'true' ) {
        //     $data['totalRecords'] =  $actual_row->count();
        //     $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);
        // }



        $data['bill'] = explode(",", $data['bill_string']);
        if (empty($data['bill'][0])  ||  count($data['bill'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }


        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


        if (!empty($data['bill'])) {

            $data['bill'] = DB::table('bills')

                ->select(
                    'bills.*',
                    'vendors.company_name',
                    'vendors.vendor_name',
                    'vendors.vendor_code',

                )
                ->leftJoin('vendors', 'bills.vendor_id', 'vendors.vendor_id')
                ->where('bills.user_id', '=', Auth::id())
                ->whereIn('bills.bill_id', $data['bill'])
                ->orderBy($sort, $order_by)
                ->get();





            foreach ($data['bill'] as $key => $bill) {


                $currency_symbol =  DB::table('currencies')->where('currency_code', $bill->currency_code)->first();

                if (!empty($currency_symbol)) {
                    $data['bill'][$key]->symbol = DB::table('currencies')->where('currency_code', $bill->currency_code)->first()->currency_symbol;
                } else {
                    $data['bill'][$key]->symbol = '';
                }



                $data['bill'][$key]->bill_date_utc = $bill->bill_date;
                $data['bill'][$key]->bill_date =  !empty($bill->bill_date) ? getTimeDateDisplay($user->time_zone_id, $bill->bill_date, 'Y-m-d', 'Y-m-d') : '';

                $data['bill'][$key]->due_date_utc = $bill->due_date;
                $data['bill'][$key]->due_date =  !empty($bill->due_date) ? getTimeDateDisplay($user->time_zone_id, $bill->due_date, 'Y-m-d', 'Y-m-d') : '';


                $data['bill'][$key]->created_at_utc = $bill->created_at;
                $data['bill'][$key]->created_at =  !empty($bill->created_at) ? getTimeDateDisplay($user->time_zone_id, $bill->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                $data['bill'][$key]->updated_at_utc = $bill->updated_at;
                $data['bill'][$key]->updated_at =  !empty($bill->updated_at) ? getTimeDateDisplay($user->time_zone_id, $bill->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';


                $today = Carbon::now($data['timezone']->timezone); // user's timezone
                if (!empty($bill->due_date_utc)) {
                    $dueDate = Carbon::parse($bill->due_date_utc);

                    if ($dueDate->lt($today)) {
                        // Due date is in past
                        $data['bill'][$key]->due_status_text = 'Due for ' . $dueDate->diffInDays($today) . ' day(s)';
                        $data['bill'][$key]->due_type = 'overdue';
                    } elseif ($dueDate->gt($today)) {
                        // Due date is in future
                        $data['bill'][$key]->due_status_text = 'Due in ' . $today->diffInDays($dueDate) . ' day(s)';
                        $data['bill'][$key]->due_type = 'upcoming';
                    } else {
                        // Due date is today
                        $data['bill'][$key]->due_status_text = 'Due today';
                        $data['bill'][$key]->due_type = 'today';
                    }
                } else {
                    $data['bill'][$key]->due_status_text = 'N/A';
                    $data['bill'][$key]->due_type = 'unknown';
                }
            }
        }


        // dd( $data['bill']);
        return view('pages/bill.list', compact('data'));
    }

    public function getRecordPaymentForm(Request $request)
    {
        $data = [];

        $data =   \DB::table('bills')
            ->leftJoin('vendors', 'bills.vendor_id', 'vendors.vendor_id')
            ->where('bills.user_id', '=', Auth::id())
            ->where('bills.bill_code', $request->input('bill_code'))->first();
        return view('pages/invoice.payment', compact('data'));
    }


    public function recordPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'bill_id' => 'required|exists:bills,bill_id',
                'amount' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method' => 'required|in:cash,bank,card,upi,paypal,stripe,other',
                'transaction_reference' => 'nullable|string|max:100',
                'notes' => 'nullable|string',
            ], [
                'bill_id.required' => 'Invoice ID is required.',
                'bill_id.exists' => 'The selected invoice does not exist.',
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
                'bill_id' => $data['bill_id'],
                'user_id' => Auth::id(),
                'amount' => $data['amount'],
                'payment_date' => $data['payment_date'],
                'payment_method' => $data['payment_method'],
                'transaction_reference' => $data['transaction_reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            // Optionally, update the invoice total_due
            $bill = BillModel::find($data['bill_id']);
            if ($bill) {
                $bill->total_due = $bill->total_due - $data['amount'];
                $bill->advance_payment = $bill->advance_payment + $data['amount'];

                if ($bill->total_due <= 0) {
                    $bill->status = 'paid';
                    $bill->is_paid = 'Y';
                    $bill->paid_at = Carbon::now('UTC')->format('Y-m-d H:i:s');
                }

                $bill->save();
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


        $data['states'] = \DB::table('country_states')->where('country_id', $data['setting']->country_id)->orderBy('state_name', 'ASC')->get();
        return view('pages/bill.add', compact('data'));
    }

    public function edit(Request $request, $bill_code)
    {
        $data = [];

        $data['bill'] = \DB::table('bills')
            ->select(
                'vendors.*',
                'bills.*',
                'countries.country_name',
                'country_states.state_name',
            )
            ->leftJoin('vendors', 'bills.vendor_id', 'vendors.vendor_id')
            ->leftJoin('countries', 'countries.country_id', 'vendors.country_id')
            ->leftJoin('country_states', 'country_states.state_id', 'vendors.state_id')
            ->where('bills.user_id', '=', Auth::id())
            ->where('bill_code', $bill_code)->first();




        if (empty($data['bill'])) {
            return abort(404);
        }

        $data['items'] = json_decode($data['bill']->item_json, true);

        $data['items'] = json_decode($data['items'], true);



        $data['vendor_details_html'] = '';

        $data['vendor_details_html'] .= !empty($data['bill']->company_name) ? $data['bill']->company_name . '<br>' : $data['bill']->vendor_name . '<br>';

        if (!empty($data['bill']->address_1)) {
            $data['vendor_details_html'] .= $data['bill']->address_1 . '<br>';
        }
        if (!empty($data['bill']->address_2)) {
            $data['vendor_details_html'] .= $data['bill']->address_2 . '<br>';
        }

        if (!empty($data['bill']->state_name)) {
            $data['vendor_details_html'] .= $data['bill']->state_name . ', ';
        }
        if (!empty($data['bill']->country_name)) {
            $data['vendor_details_html'] .= $data['bill']->country_name . ' ';
        }
        if (!empty($data['bill']->zip)) {
            $data['vendor_details_html'] .= $data['bill']->zip;
        }



        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = \DB::table('templates')->orderBy('template_name', 'ASC')->get();
        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();





        $data['setting'] = \DB::table('settings')->where('user_id', Auth::id())->first();

        // if (!empty($data['setting'])) {
        //     $data['setting']->country = \DB::table('countries')->where('country_id',  $data['setting']->country_id)->first();
        //     $data['setting']->state = \DB::table('country_states')->where('state_id',  $data['setting']->state_id)->first();
        // }


        $data['recurring'] = \DB::table('recurring_bills')
            ->where('bill_id', $data['bill']->bill_id)
            ->first();

        $data['states'] = \DB::table('country_states')->where('country_id', $data['setting']->country_id)->orderBy('state_name', 'ASC')->get();
        // dd($data);
        return view('pages/bill.edit', compact('data'));
    }

    private function generateUniqueBillCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\BillModel::where('bill_code', $code)->exists());

        return $code;
    }


    public function update(Request $request)
    {



        try {
            $validator = Validator::make($request->all(), [
                'vendor_id' => 'required',
                'bill_number' => 'required|string|max:255',
                'currency_code' => 'required',
                'template_id' => 'required',
                'bill_date' => 'required|date',
                'due_date' => 'required|date',
                'item' => 'required',
            ], [
                'vendor_id.required' => 'Please select a vendor for the bill.',
                'bill_number.required' => 'Bill number is required.',
                'bill_number.max' => 'Bill number should not exceed 255 characters.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for Bill.',
                'bill_date.required' => 'Bill date is required.',
                'bill_date.date' => 'Bill date must be a valid date.',
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

            // Fetch invoice using bill_code and user_id
            $bill = BillModel::where('bill_code', $request->input('bill_code'))
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
            $bill->update([
                'vendor_id'        => $request->input('vendor_id'),
                'bill_number'   => $request->input('bill_number'),
                'bill_date'     => $request->input('bill_date'),
                'due_date'         => $request->input('due_date'),
                'sub_total'        => $request->input('hidden_sub_total'),
                'total_tax'        => $request->input('hidden_total_tax'),
                'total_discount'   => $request->input('hidden_total_discount'),
                'grand_total'      => $request->input('hidden_grand_total'),
                'round_off'      => $request->input('hidden_round_off'),
                'total_due'        => $request->input('hidden_total_due'),
                'notes'            => $request->input('notes'),
                'currency_code'    => $request->input('currency_code'),
                'item_json'        => json_encode($itemJson),
                'template_id'      => $request->input('template_id') ?? 1,
                'bill_file_path'      => $request->input('bill_file_path') ?? '',
                'is_recurring'      => $request->input('is_recurring') == 'on' ? 'Y' : 'N',

                'supply_source_state_id'    => $request->input('supply_source_state_id'),
                'destination_source_state_id'    => $request->input('destination_source_state_id'),
                'bill_month'    => Carbon::parse($request->input('bill_date'))->month,
                'bill_financial_year'    => Carbon::parse($request->input('bill_date'))->format('Y'),
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



                DB::table('recurring_bills')->updateOrInsert(
                    [
                        'bill_id' =>  $bill->bill_id,
                        'user_id' =>  Auth::id()

                    ],
                    $recurring_data
                );
            }



            return response()->json([
                "error" => 0,
                "message" => "Bill Updated Successfully!"
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('Error while updating bill: ' . $e->getMessage());

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
                'vendor_id' => 'required',
                'bill_number' => 'required|string|max:255',
                'currency_code' => 'required',
                'template_id' => 'required',
                'bill_date' => 'required|date',
                'due_date' => 'required|date',
                'item' => 'required',
            ], [
                'vendor_id.required' => 'Please select a vendor for the bill.',
                'bill_number.required' => 'Bill number is required.',
                'bill_number.max' => 'Bill number should not exceed 255 characters.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for Bill.',
                'bill_date.required' => 'Bill date is required.',
                'bill_date.date' => 'Bill date must be a valid date.',
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
            $vendor_id = $request->input('vendor_id');
            $billNumber = $request->input('bill_number');
            $billDate = $request->input('bill_date');
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



            $bill = BillModel::create([
                'vendor_id'        => $request->input('vendor_id'),
                'bill_number'   => $request->input('bill_number'),
                'bill_code'   => $this->generateUniqueBillCode(),
                'user_id'   => Auth::id(),
                'bill_date'     => $request->input('bill_date'),
                'due_date'         => $request->input('due_date'),
                'sub_total'        => $request->input('hidden_sub_total'),
                'total_tax'        => $request->input('hidden_total_tax'),
                'total_discount'   => $request->input('hidden_total_discount'),
                'grand_total'      => $request->input('hidden_grand_total'),
                'round_off'      => $request->input('hidden_round_off'),
                'total_due'        => $request->input('hidden_total_due'),
                'notes'            => $request->input('notes'),
                'currency_code'    => $request->input('currency_code'),
                'item_json'        => json_encode($itemJson),
                'template_id'      => $request->input('template_id') ?? 1,
                'bill_file_path'      => $request->input('bill_file_path') ?? '',
                'is_recurring'      => $request->input('is_recurring') == 'on' ? 'Y' : 'N',
                'supply_source_state_id'    => $request->input('supply_source_state_id'),
                'destination_source_state_id'    => $request->input('destination_source_state_id'),
                'bill_month'    => Carbon::parse($request->input('bill_date'))->month,
                'bill_financial_year'    => Carbon::parse($request->input('bill_date'))->format('Y'),
            ]);

            // Get the last inserted ID (bill_id)
            $lastInsertedId = $bill->bill_id;

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


                    $recurring_data['bill_id'] =  $lastInsertedId;
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




                    DB::table('recurring_bills')->insert($recurring_data);
                }
            }

            if ($request->has('send_status') && $request->input('send_status') == 'true') {

                $last_notification_id = DB::table('notifications')->insertGetId([
                    'user_id' => $userId,
                    'bill_id' => $lastInsertedId,  // This should be the invoice ID
                    'notification_type' => 'email',
                    'template_id' => 1,
                    'is_read' => 'N',
                    'processing_status' => 'pending',
                    'cron_start_datetime' => null,
                    'cron_end_datetime' => null,
                    'processing_log' => null,
                ]);

                // Check if the notification was inserted successfully and get the associated bill_id from the notifications table
                if ($last_notification_id) {
                    // Get the bill_id from the notification (because it should be linked)
                    $billIdFromNotification = DB::table('notifications')
                        ->where('notification_id', $last_notification_id)
                        ->value('bill_id'); // Get the bill_id from the notification table

                    // Update the invoice's 'is_sent' status
                    if ($billIdFromNotification) {
                        DB::table('bills')->where('bill_id', $billIdFromNotification) // Use the bill_id here
                            ->update([
                                'is_sent' => 'submitted',
                            ]);
                    }
                }
            }




            return response()->json([
                "error" => 0,
                //'download_url' => route('invoice.download', ['bill_code' => $data['bill_code']]),
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


        $bill_code = $request->input('bill_code');

        $bill_template_id =  shortcode('bill', $bill_code,  "{{bill_template_id}}");



        $template =  DB::table('bill_templates')->where('template_id', $bill_template_id)->first();



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


        $html =  shortcode('bill', $bill_code, $html);

        return response()->json([
            "error" => 0,
            'html' => $html,
            "message" => "Bill Saved Successfully!"
        ]);
    }

    public function shortcode($bill_code)
    {

        $bill =  getShortcode($bill_code);
        dd($bill);
    }

    public function downloadMultiple(Request $request)
    {
        $bills_code = $request->bills_code;

        if (empty($bills_code) || !is_array($bills_code)) {
            return back()->with('error', 'No bills selected.');
        }

        $zipFileName = 'bills_' . time() . '.zip';
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {

            foreach ($bills_code as $bill_code) {

                // Fetch invoice
                $bill = DB::table('bills')
                    ->select('bill_code')
                    ->where('bill_code', $bill_code)
                    ->where('bills.user_id', '=', Auth::id())
                    ->first();

                if (!$bill) continue;

                $bill_code = $bill->bill_code;

                // Extract template ID from shortcode
                $bill_template_id = shortcode('bill', $bill_code, "{{bill_template_id}}");

                // Fetch template
                $template = DB::table('bill_templates')->where('template_id', $bill_template_id)->first();
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

                $html = shortcode('bill', $bill_code, $html);

                // Generate PDF content
                $pdf = Pdf::loadHTML($html)
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);
                $pdfContent = $pdf->output();

                // Ensure unique filename in zip
                $fileName = $bill_code . '.pdf';
                if ($zip->locateName($fileName) !== false) {
                    $fileName = $bill_code . '_' . uniqid() . '.pdf';
                }

                $zip->addFromString($fileName, $pdfContent);
            }

            $zip->close();
        } else {
            return back()->with('error', 'Unable to create ZIP file.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }



    public function billDownload(Request $request, $bill_code)
    {


        $bill_template_id =  shortcode('bill', $bill_code, "{{bill_template_id}}");

        $template =  DB::table('bill_templates')->where('template_id', $bill_template_id)->first();



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


        $html =  shortcode('bill', $bill_code, $html);
        // dd($html);
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        if ($request->input('preview') === 'true') {
            return $pdf->stream($bill_code . '.pdf', ["Attachment" => false]);
        } else {
            return $pdf->download(time() . '_' . $bill_code . '.pdf');
        }
    }


    public function bulkDelete(Request $request)
    {


        $request->validate([
            'bills_code' => 'required|array',
            'bills_code.*' => 'exists:bills,bill_code',
        ]);

        try {


            BillModel::whereIn('bill_code', $request->bills_code)
                ->where('user_id', auth()->id()) // Ensures only current user's bills are deleted
                ->delete();
            session()->flash('success', 'bills deleted successfully!');
            return response()->json([
                'error' => 0,
                'message' => 'bills deleted successfully.'
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'bills deleted failed!');
            return response()->json([
                'error' => 1,
                'message' => 'Error deleting bills: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {

        try {

            BillModel::where('bill_code', $request->bill_code)
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
                'message' => 'Error deleting bills: ' . $e->getMessage()
            ]);
        }
    }




    public function queueEmail(Request $request)
    {
        $bills_code = $request->input('bills_code');
        $userId = auth()->id();

        foreach ($bills_code as $bill_code) {
            $bill =  DB::table('bills')->where('bill_code', $bill_code)->first();


            DB::table('notifications')->insert([
                'user_id' => $userId,
                'bill_id' => $bill->bill_id,
                'bill_code' => $bill_code,
                'notification_type' => 'email',
                'template_id' => 1,
                'is_read' => 'N',
                'processing_status' => 'pending',
                'cron_start_datetime' => null,
                'cron_end_datetime' => null,
                'processing_log' => null,
            ]);
            DB::table('bills')->where([
                'user_id' => $userId,
                'bill_code' => $bills_code,
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
