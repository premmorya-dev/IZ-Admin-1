<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\ExpenseModel;
use App\Models\SettingModel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use ZipArchive;


class ExpenseController extends Controller
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
            'expense_id' => 'expenses.expense_id',
            'expense_number' => 'expenses.expense_number',
            'expense_date' => 'expenses.expense_date',
            'amount' => 'expenses.amount',
            'created_at' => 'expenses.created_at',
            'updated_at' => 'expenses.updated_at',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'expenses.expense_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('expenses')
                ->select(
                    'expenses.expense_id',
                );
            // ->leftJoin('clients', 'expenses.client_id', 'clients.client_id');



            // **Applying Filters**


            if ($request->filled('expense_number')) {
                $query->where('expenses.expense_number', 'Like', "%" . $request->input('expense_number') . "%");
            }



            if ($request->filled('expense_date')) {
                $expense_date = parseDateRange($request->input('expense_date'));

                $query->where('expenses.expense_date', '>=',  convertToUTCDateOnly($expense_date['start_date']));
                $query->where('expenses.expense_date', '<=',  convertToUTCDateOnly($expense_date['end_date']));
            }

            if ($request->filled('sub_total')) {
                $query->where('expenses.sub_total', '=', $request->input('sub_total'));
            }

            if ($request->filled('tax_total')) {
                $query->where('expenses.tax_total', '=', $request->input('tax_total'));
            }
            if ($request->filled('discount')) {
                $query->where('expenses.discount', '=', $request->input('discount'));
            }
            if ($request->filled('amount')) {
                $query->where('expenses.amount', '=', $request->input('amount'));
            }
            if ($request->filled('currency')) {
                $query->where('expenses.currency', '=', $request->input('currency'));
            }


            $query->where('expenses.user_id', '=', Auth::id());
            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['expense_string'] = implode(",", array_column($query, 'expense_id'));
        } else {

            $query = DB::table('expenses')
                ->select(
                    'expenses.expense_id',
                );

            $query->where('expenses.user_id', '=', Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['expense_string'] = implode(",", array_column($query, 'expense_id'));
        }




        // else {
        //     $query->orderBy('notification_job_queue.registration_id', $order_by);
        // }

        // $actual_row = $query;
        // if($request->has('filters') && $request->input('filters') == 'true' ) {
        //     $data['totalRecords'] =  $actual_row->count();
        //     $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);
        // }



        $data['expense'] = explode(",", $data['expense_string']);
        if (empty($data['expense'][0])  ||  count($data['expense'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }

        if (!empty($data['expense'])) {

            $data['expense'] = DB::table('expenses')

                ->select(
                    'expenses.*',
                    // 'clients.company_name',
                    // 'clients.client_code',

                )
                // ->leftJoin('clients', 'expenses.client_id', 'clients.client_id')
                ->where('expenses.user_id', '=', Auth::id())
                ->whereIn('expenses.expense_id', $data['expense'])
                ->orderBy($sort, $order_by)
                ->get();




            $user = DB::table('users')->where('user_id', Auth::id())->first();
            $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();



            foreach ($data['expense'] as $key => $expense) {


                $currency_symbol =  DB::table('currencies')->where('currency_code', $expense->currency_code)->first();

                if (!empty($currency_symbol)) {
                    $data['expense'][$key]->symbol = DB::table('currencies')->where('currency_code', $expense->currency_code)->first()->currency_symbol;
                } else {
                    $data['expense'][$key]->symbol = '';
                }



                $data['expense'][$key]->expense_date_utc = $expense->expense_date;
                $data['expense'][$key]->expense_date =  !empty($expense->expense_date) ? getTimeDateDisplay($user->time_zone_id, $expense->expense_date, 'Y-m-d', 'Y-m-d') : '';


                $data['expense'][$key]->created_at_utc = $expense->created_at;
                $data['expense'][$key]->created_at =  !empty($expense->created_at) ? getTimeDateDisplay($user->time_zone_id, $expense->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                $data['expense'][$key]->updated_at_utc = $expense->updated_at;
                $data['expense'][$key]->updated_at =  !empty($expense->updated_at) ? getTimeDateDisplay($user->time_zone_id, $expense->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            }
        }

        return view('pages/expense.list', compact('data'));
    }

    public function getRecordPaymentForm(Request $request)
    {
        $data = [];

        $data =   \DB::table('expenses')
            ->leftJoin('clients', 'expenses.client_id', 'clients.client_id')
            ->where('expenses.user_id', '=', Auth::id())
            ->where('expenses.expense_code', $request->input('expense_code'))->first();
        return view('pages/expense.payment', compact('data'));
    }


    public function recordPayment(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'expense_id' => 'required|exists:expense,expense_id',
                'amount' => 'required|numeric|min:0.01',
                'payment_date' => 'required|date',
                'payment_method' => 'required|in:cash,bank,card,upi,paypal,stripe,other',
                'transaction_reference' => 'nullable|string|max:100',
                'notes' => 'nullable|string',
            ], [
                'expense_id.required' => 'expense ID is required.',
                'expense_id.exists' => 'The selected expense does not exist.',
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
                'expense_id' => $data['expense_id'],
                'user_id' => Auth::id(),
                'amount' => $data['amount'],
                'payment_date' => $data['payment_date'],
                'payment_method' => $data['payment_method'],
                'transaction_reference' => $data['transaction_reference'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            // Optionally, update the expense total_due
            $expense = ExpenseModel::find($data['expense_id']);
            if ($expense) {
                $expense->total_due = $expense->total_due - $data['amount'];
                $expense->advance_payment = $expense->advance_payment + $data['amount'];

                if ($expense->total_due <= 0) {
                    $expense->status = 'paid';
                    $expense->is_paid = 'Y';
                    $expense->paid_at = Carbon::now('UTC')->format('Y-m-d H:i:s');
                }

                $expense->save();
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




        return view('pages/expense.add', compact('data'));
    }

    public function edit(Request $request, $expense_code)
    {
        $data = [];

        $data['expense'] = \DB::table('expenses')
            ->select('expenses.*')
            ->where('expenses.user_id', '=', Auth::id())
            ->where('expense_code', $expense_code)->first();


        if (empty($data['expense'])) {
            return abort(404);
        }


        // Check if image exists and file is present in public folder
        if ($data['expense']->expense_image && file_exists(public_path($data['expense']->expense_image))) {
            $data['storedLogo'] = asset($data['expense']->expense_image);
            $data['showLogo'] = true;
        } else {
            $data['storedLogo'] = asset('no-image.png'); // fallback placeholder
            $data['showLogo'] = false;
        }
        $data['items'] = json_decode($data['expense']->item_json, true);


        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = \DB::table('templates')->orderBy('template_name', 'ASC')->get();
        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();




        $data['setting'] = \DB::table('settings')->where('user_id', Auth::id())->first();


        $data['recurring'] = \DB::table('recurring_expenses')
            ->where('expense_id', $data['expense']->expense_id)
            ->first();


        // dd($data);
        return view('pages/expense.edit', compact('data'));
    }

    private function generateUniqueExpenseCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\ExpenseModel::where('expense_code', $code)->exists());

        return $code;
    }


    public function update(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                // 'client_id' => 'required',
                'expense_number' => 'required|string|max:255',
                'currency_code' => 'required',
                'template_id' => 'required',
                'expense_date' => 'required|date',
                'upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',

            ], [
                // 'client_id.required' => 'Please select a client for the expenses.',
                'expense_number.required' => 'expense number is required.',
                'expense_number.max' => 'expense number should not exceed 255 characters.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for expenses.',
                'expense_date.required' => 'expense date is required.',
                'expense_date.date' => 'expense date must be a valid date.',

            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $userId = Auth::id();

            // Fetch expense using expense_code and user_id
            $expense = ExpenseModel::where('expense_code', $request->input('expense_code'))
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

            // === Handle Logo Removal ===
            if ($request->has('remove_upload') && $request->input('remove_upload') == '1') {
                if ($expense && $expense->expense_image && file_exists(public_path($expense->expense_image))) {
                    unlink(public_path($expense->expense_image)); // delete old file
                }
                $data['upload'] = null;
            } elseif ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $path = public_path("storage/expense");

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);

                $data['upload'] = "storage/expense/{$filename}";
            } else {

                if ($expense && $expense->expense_image && file_exists(public_path($expense->expense_image))) {
                    $data['upload'] = $expense->expense_image;
                } else {
                    $data['upload'] = NULL;
                }
            }

            // dd($request->all());
            // Update expense fields

            $expense->update([
                // 'client_id'        => $request->input('client_id'),             
                'expense_date'     => $request->input('expense_date'),
                'expense_image'     => $data['upload'],
                'payment_mode'     => $request->input('payment_mode'),
                'is_paid'     =>     $request->has('is_paid')  && $request->input('is_paid') == 'Y'  ? 'Y' : 'N',
                'sub_total'        => $request->input('hidden_sub_total'),
                'total_tax'        => $request->input('hidden_total_tax'),
                'total_discount'   => $request->input('hidden_total_discount'),
                'amount'      => $request->input('hidden_grand_total'),
                'total_due'        => $request->input('hidden_total_due'),
                'notes'            => $request->input('notes'),
                'currency_code'    => $request->input('currency_code'),
                'item_json'        => json_encode($itemJson),
                'template_id'      => $request->input('template_id'),
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



                DB::table('recurring_expenses')->updateOrInsert(
                    [
                        'expense_id' =>  $expense->expense_id,
                        'user_id' =>  Auth::id()

                    ],
                    $recurring_data
                );
            }


            return response()->json([
                "error" => 0,
                "message" => "Expense Updated Successfully!"
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('Error while updating expense: ' . $e->getMessage());

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
                // 'client_id' => 'required',
                'expense_number' => 'required|string|max:255',
                'upload' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
                'currency_code' => 'required',
                'template_id' => 'required',
                'expense_date' => 'required|date',

            ], [
                // 'client_id.required' => 'Please select a client for the expenses.',
                'expense_number.required' => 'expense number is required.',
                'expense_number.max' => 'expense number should not exceed 255 characters.',
                'currency_code.required' => 'Currency is required.',
                'template_id.required' => 'Please select template for expenses.',
                'expense_date.required' => 'expense date is required.',
                'expense_date.date' => 'expense date must be a valid date.',

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


            // Create the expense


            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $path = public_path("storage/expense");

                if (!file_exists($path)) {
                    mkdir($path, 0755, true);
                }

                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $filename);

                $data['upload'] = "storage/expense/{$filename}";
            } else {
                $data['upload'] = NULL;
            }


            $expense = ExpenseModel::create([
                'user_id' => Auth::id(),
                // 'client_id' => $clientId,
                'expense_number' =>  $request->input('expense_number'),
                'is_paid'     => $request->has('is_paid')  && $request->input('is_paid') == 'Y'  ? 'Y' : 'N',
                'expense_date' => $request->input('expense_date'),
                'expense_date' => $request->input('expense_date'),
                'expense_image'     => $data['upload'],
                'payment_mode'     => $request->input('payment_mode'),
                'sub_total' => $request->input('hidden_sub_total'),
                'total_tax' => $request->input('hidden_total_tax'),
                'total_discount' => $request->input('hidden_total_discount'),
                'amount' =>  $request->input('hidden_grand_total'),
                'total_due' => $request->input('hidden_total_due'),
                'notes' => $request->input('notes'),
                'currency_code' => $request->input('currency_code'),
                'item_json' => json_encode($itemJson),
                'expense_code' => $this->generateUniqueExpenseCode(),
                'template_id' => $request->input('template_id')
            ]);

            // Get the last inserted ID (expense_id)
            $lastInsertedId = $expense->expense_id;

            if (!empty($lastInsertedId) && $request->has('is_recurring')) {
                $recurring_data['expense_id'] =  $lastInsertedId;
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
                DB::table('recurring_expenses')->insert($recurring_data);
            }
            return response()->json([
                "error" => 0,
                //'download_url' => route('expenses.download', ['expense_code' => $data['expense_code']]),
                "message" => "Expense Saved Successfully!"
            ]);
        } catch (ValidationException $e) {
            dd($e->getMessage());
            Log::channel('admin')->error('error while preparing expense: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        }
    }


    public function viewModel(Request $request)
    {


        $expense_code = $request->input('expense_code');
        $expense_template_id =  shortcode('expense', $expense_code, "{{expense_template_id}}");

        $template =  DB::table('templates')->where('template_id', $expense_template_id)->first();



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


        $html =  shortcode('expense', $expense_code, $html);

        return response()->json([
            "error" => 0,
            'html' => $html,
            "message" => "expense Saved Successfully!"
        ]);
    }

    public function shortcode($expense_code)
    {

        $expense =  getShortcode($expense_code);
        dd($expense);
    }

    public function downloadMultiple(Request $request)
    {
        $expense_code = $request->expense_code;

        if (empty($expense_code) || !is_array($expense_code)) {
            return back()->with('error', 'No expense selected.');
        }

        $zipFileName = 'expense_' . time() . '.zip';
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {

            foreach ($expense_code as $expense_code) {

                // Fetch expense
                $expense = DB::table('expenses')
                    ->select('expense_code')
                    ->where('expense_code', $expense_code)
                    ->where('expenses.user_id', '=', Auth::id())
                    ->first();

                if (!$expense) continue;

                $expense_code = $expense->expense_code;

                // Extract template ID from shortcode
                $expense_template_id = shortcode('expense', $expense_code, "{{expense_template_id}}");

                // Fetch template
                $template = DB::table('templates')->where('template_id', $expense_template_id)->first();
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

                $html = shortcode('expense', $expense_code, $html);

                // Generate PDF content
                $pdf = Pdf::loadHTML($html)
                    ->setPaper('a4', 'portrait')
                    ->setWarnings(false);
                $pdfContent = $pdf->output();

                // Ensure unique filename in zip
                $fileName = $expense_code . '.pdf';
                if ($zip->locateName($fileName) !== false) {
                    $fileName = $expense_code . '_' . uniqid() . '.pdf';
                }

                $zip->addFromString($fileName, $pdfContent);
            }

            $zip->close();
        } else {
            return back()->with('error', 'Unable to create ZIP file.');
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function expenseDownload($expense_code)
    {


        $expense_template_id =  shortcode('expense', $expense_code, "{{expense_template_id}}");

        $template =  DB::table('templates')->where('template_id', $expense_template_id)->first();



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


        $html =  shortcode('expense', $expense_code, $html);
        // dd($html);
        $pdf = Pdf::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
            ]);

        return $pdf->download(time() . '_' . $expense_code . '.pdf');
    }


    public function bulkDelete(Request $request)
    {


        $request->validate([
            'expense_code' => 'required|array',
            'expense_code.*' => 'exists:expenses,expense_code',
        ]);

        try {


            ExpenseModel::whereIn('expense_code', $request->expense_code)
                ->where('user_id', auth()->id()) // Ensures only current user's expense are deleted
                ->delete();
            session()->flash('success', 'expense deleted successfully!');
            return response()->json([
                'error' => 0,
                'message' => 'expense deleted successfully.'
            ]);
        } catch (\Exception $e) {
            session()->flash('error', 'expense deleted failed!');
            return response()->json([
                'error' => 1,
                'message' => 'Error deleting expense: ' . $e->getMessage()
            ]);
        }
    }

    public function destroy(Request $request)
    {

        try {

            ExpenseModel::where('expense_code', $request->expense_code)
                ->where('user_id', auth()->id())
                ->delete();


            session()->flash('status', 'expense deleted successfully!');
            return response()->json([
                'error' => 0,
                'message' => 'expense deleted successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 1,
                'message' => 'Error deleting expense: ' . $e->getMessage()
            ]);
        }
    }




    public function queueEmail(Request $request)
    {
        $expense_code = $request->input('expense_code');
        $userId = auth()->id();

        foreach ($expense_code as $expense_code) {
            $expense =  DB::table('expenses')->where('expense_code', $expense_code)->first();


            DB::table('notifications')->insert([
                'user_id' => $userId,
                'expense_id' => $expense->expense_id,
                'expense_code' => $expense_code,
                'notification_type' => 'email',
                'template_id' => 1,
                'is_read' => 'N',
                'processing_status' => 'pending',
                'cron_start_datetime' => null,
                'cron_end_datetime' => null,
                'processing_log' => null,
            ]);
            DB::table('expenses')->where([
                'user_id' => $userId,
                'expense_code' => $expense_code,
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
