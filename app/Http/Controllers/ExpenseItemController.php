<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ExpenseItemModel;



class ExpenseItemController extends Controller
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
            'expense_item_id' => 'expense_items.expense_item_id',
            'expense_item_name' => 'expense_items.expense_item_name',          
            'status' => 'expense_items.status',


        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'expense_items.expense_item_id';
        }
        // sorting

        if ($request->has('filters')) {



            $query = DB::table('expense_items')
                ->select(
                    'expense_items.expense_item_id',
                );


            $query->where('expense_items.user_id',  Auth::id());


            // **Applying Filters**



            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('expense_items.status', $status);
            }


            if ($request->filled('expense_item_name')) {
                $query->where('expense_items.expense_item_name', 'LIKE', '%' . $request->input('expense_item_name') . '%');
            }

          
            if ($request->filled('hsn_sac')) {
                $query->where('expense_items.hsn_sac', '=',  $request->input('hsn_sac'));
            }
            if ($request->filled('expense_item_type')) {
                $query->where('expense_items.expense_item_type', '=',  $request->input('expense_item_type'));
            }


            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['expense_item_string'] = implode(",", array_column($query, 'expense_item_id'));
        } else {

            $query = DB::table('expense_items')
                ->select(
                    'expense_items.expense_item_id',
                );

            $query->where('expense_items.user_id',  Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['expense_item_string'] = implode(",", array_column($query, 'expense_item_id'));
        }

        $data['expense_items'] = explode(",", $data['expense_item_string']);
        if (empty($data['expense_items'][0])  ||  count($data['expense_items'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }

        if (!empty($data['expense_items'])) {

            $data['expense_items'] = DB::table('expense_items')
                ->select(
                    'expense_items.*',
                  
                )
                ->where('expense_items.user_id',  Auth::id())
                ->whereIn('expense_items.expense_item_id', $data['expense_items'])
                ->orderBy($sort, $order_by)
                ->get();


            $user = DB::table('users')->where('user_id', Auth::id())->first();
            $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


            // foreach ($data['expense_items'] as $key => $tax) {
            //     $data['expense_items'][$key]->created_at =  !empty($tax->created_at) ? getTimeDateDisplay($user->time_zone_id, $tax->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            //     $data['expense_items'][$key]->updated_at =  !empty($tax->updated_at) ? getTimeDateDisplay($user->time_zone_id, $tax->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            // }
        }


        return view('pages/expense_item.list', compact('data'));
    }


    public function create(Request $request)
    {
        $data = [];
        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();


        return view('pages/expense_item.add', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'expense_item_name' => 'required|string|max:100',           
             
                'hsn_sac' => 'required',
                'expense_item_type' => 'required',
                'unit_price' => 'required',              
                'status' => 'required',
                'tax_id' => 'required',
                'discount_id' => 'required',

            ], []);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            $expense_item_id =  DB::table('expense_items')->insertGetId([
                'expense_item_name'   => $request->input('expense_item_name'),
                'user_id'     => Auth::id(),
                'expense_item_code'   => $this->generateUniqueexpense_itemCode(),              
              
                'hsn_sac'     => $request->input('hsn_sac') ?? '',
                'expense_item_type'   => $request->input('expense_item_type'),
                'unit_price'  => $request->input('unit_price') ?? 0,
               
                'status'      => $request->input('status') ?? 'Y',
                'tax_id'      => $request->input('tax_id') ?? null,
                'discount_id' => $request->input('discount_id') ?? null,
                           ]);


            return response()->json([
                'error' => 0,
                'message' => 'expense_item added Successfully!',
                'expense_item_id' =>  $expense_item_id
            ]);
        } catch (ValidationException $e) {
            dd($e->getMessage());
            Log::channel('admin')->error('error while preparing expense_item: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {

            dd($e->getMessage());
            Log::channel('admin')->error('error while saving expense_item: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while saving the expense_item.'
            ], 500);
        }
    }



    public function edit(Request $request, $expense_item_code)
    {


        $data = [];

        $data['expense_item'] = ExpenseItemModel::where('user_id', Auth::id())
            ->where('expense_item_code', $expense_item_code)
            ->first();

        if (empty($data['expense_item'])) {
            return abort(404);
        }


        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();

      

        return view('pages/expense_item.edit', compact('data'));
    }



    public function update(Request $request)
    {


        try {


            $validator = Validator::make($request->all(), [
                'expense_item_name' => 'required|string|max:100',
                'hsn_sac' => 'required',              
                'expense_item_type' => 'required',
                'unit_price' => 'required',
              
                'status' => 'required',
                'tax_id' => 'required',
                'discount_id' => 'required',

            ], []);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            DB::table('expense_items')
                ->where('expense_item_code',  $request->input('expense_item_code'))
                ->update([
                    'expense_item_name'   => $request->input('expense_item_name'),
                   
                    'user_id'     => Auth::id(),
                   
                    'hsn_sac'     => $request->input('hsn_sac') ?? '',
                    'expense_item_type'   => $request->input('expense_item_type'),
                    'unit_price'  => $request->input('unit_price') ?? 0,
                  
                    'status'      => $request->input('status') ?? 'Y',
                    'tax_id'      => $request->input('tax_id') ?? null,
                    'discount_id' => $request->input('discount_id') ?? null,
                ]);

            return response()->json([
                'error' => 0,
                'message' => 'Expense Item Updated Successfully!',
                'expense_item_code' => $request->expense_item_code
            ]);
        } catch (\Exception $e) {

            \Log::channel('info')->error('error while updating expense_item: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while updating the expense item.'
            ], 500);
        }
    }



    public function destroy(Request $request)
    {
        // Check if it's bulk delete (array) or single delete (single id)
        $ids = $request->input('ids');

        if (is_array($ids)) {
            // Bulk delete
            ExpenseItemModel::where('user_id',  Auth::id())
                ->whereIn('expense_item_code', $ids)
                ->delete();
        } elseif (is_numeric($ids)) {
            // Single delete
            ExpenseItemModel::where('user_id', Auth::id())
                ->where('expense_item_code', $ids) // only if $ids is a single ID
                ->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Expense item(s) deleted successfully.'
        ]);
    }


    private function generateUniqueexpense_itemCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\ExpenseItemModel::where('expense_item_code', $code)->exists());

        return $code;
    }


    public function search(Request $request)
    {
        $query = $request->get('query', '');

        // Example: search by name or code; limit to 20 results
        $results = ExpenseItemModel::where('user_id', auth()->id())
            ->where(function ($q) use ($query) {
                $q->where('expense_item_name', 'LIKE', "%{$query}%")
                    ->orWhere('expense_item_code', 'LIKE', "%{$query}%");
            })
            ->select('expense_item_id', 'expense_item_name', 'expense_item_code', 'hsn_sac', 'unit_price', 'tax_id','discount_id' )

            ->take(20)
            ->get();



        $output = '';
        if ($results->count() > 0) {
            foreach ($results as $result) {
                $output .= '<a href="#" class="list-group-expense_item list-group-expense_item-action select-expense_item" data-expense_item_id="' . $result->expense_item_id .
                    '" data-expense_item_name="' . htmlspecialchars($result->expense_item_name) .
                    '" data-hsn_sac="' . htmlspecialchars($result->hsn_sac) .
                    '" data-unit_price="' . htmlspecialchars($result->unit_price) .
                    '" data-tax_id="' . htmlspecialchars($result->tax_id) .
                    '" data-discount_id="' . htmlspecialchars($result->discount_id) .



                    '">' . htmlspecialchars($result->expense_item_name) . '</a>';
            }
        } else {
            $output .= '<div class="list-group-expense_item">No expense_item</div>';
        }


        return response($output);
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
