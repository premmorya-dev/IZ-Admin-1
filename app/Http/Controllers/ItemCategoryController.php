<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ItemCategoryModel;



class ItemCategoryController extends Controller
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
            'item_category_id' => 'item_categories.item_category_id',
            'item_category_name' => 'item_categories.item_category_name',


        ];

        $order_by = $request->input('direction', 'asc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'item_categories.item_category_name';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('item_categories')
                ->select(
                    'item_categories.item_category_id',
                );


            $query->where('item_categories.user_id',  Auth::id());
            $query->orWhere('item_categories.user_id', 1);


            // **Applying Filters**





            if ($request->filled('item_category_name')) {
                $query->where('item_categories.item_category_name', 'LIKE', '%' . $request->input('item_category_name') . '%');
            }







            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['item_category_string'] = implode(",", array_column($query, 'item_category_id'));
        } else {

            $query = DB::table('item_categories')

                ->select(
                    'item_categories.item_category_id',
                );

            $query->where('item_categories.user_id',  Auth::id());
            $query->orWhere('item_categories.user_id', 1);
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['item_category_string'] = implode(",", array_column($query, 'item_category_id'));
        }

        $data['item_categories'] = explode(",", $data['item_category_string']);
        if (empty($data['item_categories'][0])  ||  count($data['item_categories'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }

        if (!empty($data['item_categories'])) {

            $data['item_categories'] = DB::table('item_categories')
                ->select(
                    'item_categories.*',
                )
                ->where('item_categories.user_id',  Auth::id())
                ->orWhere('item_categories.user_id', 1)
                ->whereIn('item_categories.item_category_id', $data['item_categories'])
                ->orderBy($sort, $order_by)
                ->get();


            $user = DB::table('users')->where('user_id', Auth::id())->first();
            $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


            // foreach ($data['item_categories'] as $key => $tax) {
            //     $data['item_categories'][$key]->created_at =  !empty($tax->created_at) ? getTimeDateDisplay($user->time_zone_id, $tax->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            //     $data['item_categories'][$key]->updated_at =  !empty($tax->updated_at) ? getTimeDateDisplay($user->time_zone_id, $tax->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            // }
        }

        return view('pages/item_category.list', compact('data'));
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

        $data['item_categories'] = \DB::table('item_categories')
            ->where('user_id',  Auth::id())
            ->orderBy('item_category_name', 'ASC')->get();

        return view('pages/item_category.add', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'item_category_name' => 'required|string|max:100',

            ], []);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            $item_category_id =  DB::table('item_categories')->insertGetId([
                'item_category_name'   => $request->input('item_category_name'),
                'user_id'     => Auth::id(),
                'item_category_code'   => $this->generateUniqueItemCategoryCode(),

            ]);


            return response()->json([
                'error' => 0,
                'message' => 'Item Category added Successfully!',
                'item_category_id' =>  $item_category_id
            ]);
        } catch (ValidationException $e) {
            dd($e->getMessage());
            Log::channel('admin')->error('error while preparing item: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {

            dd($e->getMessage());
            Log::channel('admin')->error('error while saving item: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while saving the item.'
            ], 500);
        }
    }



    public function edit(Request $request)
    {


        $data = [];

        $data['item_categories'] = ItemCategoryModel::where('user_id', Auth::id())
            ->where('item_category_code', $request->input('item_category_code'))
            ->first();

           

        if (empty($data['item_categories'])) { 
            return response()->json(['error' => 1 ]);
        }



        return view('pages/item_category.edit', compact('data'));
    }



    public function update(Request $request)
    {


        try {


            $validator = Validator::make($request->all(), [
                'item_category_name' => 'required|string|max:100',

            ], []);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            DB::table('item_categories')
                ->where('item_category_code',  $request->input('item_category_code'))
                ->where('user_id',  Auth::id())
                ->update([
                    'item_category_name'   => $request->input('item_category_name'),

                ]);

            return response()->json([
                'error' => 0,
                'message' => 'Item Category Updated Successfully!',
                'item_code' => $request->item_code
            ]);
        } catch (\Exception $e) {

            \Log::channel('info')->error('error while updating item: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while updating the item-category.'
            ], 500);
        }
    }



    public function destroy(Request $request)
    {
        // Check if it's bulk delete (array) or single delete (single id)
        $ids = $request->input('ids');

        if (is_array($ids)) {
            // Bulk delete          
            ItemCategoryModel::where('user_id',  Auth::id())
                ->whereIn('item_category_code', $ids)
                ->delete();
        } elseif (is_numeric($ids)) {



            ItemCategoryModel::where('user_id', Auth::id())
                ->where('item_category_code', $ids) // only if $ids is a single ID
                ->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item Category(s) deleted successfully.'
        ]);
    }


    private function generateUniqueItemCategoryCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\ItemCategoryModel::where('item_category_code', $code)->exists());

        return $code;
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
