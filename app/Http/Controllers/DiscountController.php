<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\DiscountModel;



class DiscountController extends Controller
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
            'discount_id' => 'discounts.discount_id',
            'name' => 'discounts.name',
            'percent' => 'discounts.percent',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'discounts.discount_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('discounts')
                ->select(
                    'discounts.discount_id',
                );

            $query->where('discounts.user_id', '=', Auth::id());


            // **Applying Filters**



            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('discounts.status', $status);
            }


            if ($request->filled('name')) {
                $query->where('discounts.name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if ($request->filled('percent')) {
                $query->where('discounts.percent', '=',  $request->input('percent'));
            }






            if ($request->filled('created_at')) {
                $created_at = parseDateRange($request->input('created_at'));

                $query->where('discounts.created_at', '>=', convertToUTC($created_at['start_date']));
                $query->where('discounts.created_at', '<=', convertToUTC($created_at['end_date']));
            }


            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['discount_string'] = implode(",", array_column($query, 'discount_id'));
        } else {

            $query = DB::table('discounts')
                ->select(
                    'discounts.discount_id',
                );

            $query->where('discounts.user_id', '=', Auth::id());

            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['discount_string'] = implode(",", array_column($query, 'discount_id'));
        }

        $data['discounts'] = explode(",", $data['discount_string']);
        if (empty($data['discounts'][0])  ||  count($data['discounts'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }

        if (!empty($data['discounts'])) {

            $data['discounts'] = DB::table('discounts')
                ->select(
                    'discounts.*',

                )
                ->where('discounts.user_id', '=', Auth::id())
                ->whereIn('discounts.discount_id', $data['discounts'])
                ->orderBy($sort, $order_by)
                ->get();


            $user = DB::table('users')->where('user_id', Auth::id())->first();
            $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


            foreach ($data['discounts'] as $key => $discount) {


                $data['discounts'][$key]->created_at_utc = $discount->created_at;
                $data['discounts'][$key]->created_at =  !empty($discount->created_at) ? getTimeDateDisplay($user->time_zone_id, $discount->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            }
        }


        return view('pages/discount.list', compact('data'));
    }


    public function create(Request $request)
    {
        $data = [];

        return view('pages/discount.add', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'status' => 'required',
                'percent' => 'required|numeric|between:0,100',

            ], []);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }


            $data = $validator->validated();

            $userId = Auth::id(); // Get currently authenticated user ID

            // Create client


            $discount = DiscountModel::create([
                'name' => $data['name'],
                'user_id' => Auth::id(),
                'discount_code' => $this->generateUniqueDiscountCode(),
                'status' => $data['status'] ?? 'N',
                'percent' => $data['percent'] ?? 'N',
            ]);

            return response()->json([
                'error' => 0,
                'message' => 'Discount added Successfully!',
                'data'    => [
                    'discount_id' => $discount->discount_id,
                    'discount_code' => $discount->discount_code,
                    'name'   => $discount->name,
                    'percent' => $discount->percent,
                    'status' => $discount->status,
                ]
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('error while preparing discount: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::channel('admin')->error('error while saving discount: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while saving the discount.'
            ], 500);
        }
    }



    public function edit(Request $request)
    {


        $data = [];

        $data['discount'] = DiscountModel::where('discount_code', $request->input('discount_code'))
            ->where('user_id', auth()->id())
            ->first();

        if (empty($data['discount'])) {
            return abort(404);
        }


        return view('pages/discount.edit', compact('data'));
    }



    public function update(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'status' => 'required',
                'percent' => 'required|numeric|between:0,100',

            ], []);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            $discount = DiscountModel::where('discount_code', $request->discount_code)
                ->where('user_id', auth()->id())
                ->firstOrFail();


            $discount->update([
                'name' => $data['name'],
                'status' => $request->input('status')  ?? 'N',
                'percent' => $data['percent'] ?? 'N',

            ]);

            return response()->json([
                'error' => 0,
                'message' => 'Discount Updated Successfully!',
                'discount_code' => $request->discount_code
            ]);
        } catch (\Exception $e) {
            \Log::channel('info')->error('error while updating discount: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while updating the discount.'
            ], 500);
        }
    }



    public function destroy(Request $request)
    {
        // Check if it's bulk delete (array) or single delete (single id)
        $ids = $request->input('ids');
        $userId = auth()->id(); // Get the current authenticated user's ID

        if (is_array($ids)) {
            // Bulk delete for the current user
            DiscountModel::whereIn('discount_id', $ids)
                ->where('user_id', $userId)  // Ensure it's the current user's discount
                ->delete();
        } elseif (is_numeric($ids)) {
            // Single delete for the current user
            DiscountModel::where('discount_id', $ids)
                ->where('user_id', $userId)  // Ensure it's the current user's discount
                ->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Discount deleted successfully.'
        ]);
    }

    private function generateUniqueDiscountCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\DiscountModel::where('discount_code', $code)->exists());

        return $code;
    }
}
