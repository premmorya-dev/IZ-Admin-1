<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ItemModel;



class ItemController extends Controller
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
            'item_id' => 'items.item_id',
            'item_name' => 'items.item_name',
            'item_category_id' => 'items.item_category_id',
            'stock' => 'items.stock',


        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'items.item_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('items')
                ->select(
                    'items.item_id',
                );

            $query->leftJoin('item_categories', 'item_categories.item_category_id', 'items.item_category_id');

            $query->where('items.user_id',  Auth::id());


            // **Applying Filters**



            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('items.status', $status);
            }


            if ($request->filled('item_name')) {
                $query->where('items.item_name', 'LIKE', '%' . $request->input('item_name') . '%');
            }

            if ($request->filled('sku')) {
                $query->where('items.sku', '=',  $request->input('sku'));
            }
            if ($request->filled('hsn_sac')) {
                $query->where('items.hsn_sac', '=',  $request->input('hsn_sac'));
            }
            if ($request->filled('item_type')) {
                $query->where('items.item_type', '=',  $request->input('item_type'));
            }






            if ($request->filled('created_at')) {
                $created_at = parseDateRange($request->input('created_at'));

                $query->where('items.created_at', '>=', convertToUTC($created_at['start_date']));
                $query->where('items.created_at', '<=', convertToUTC($created_at['end_date']));
            }


            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['item_string'] = implode(",", array_column($query, 'item_id'));
        } else {

            $query = DB::table('items')
                ->select(
                    'items.item_id',
                );
            $query->leftJoin('item_categories', 'item_categories.item_category_id', 'items.item_category_id');

            $query->where('items.user_id',  Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['item_string'] = implode(",", array_column($query, 'item_id'));
        }

        $data['items'] = explode(",", $data['item_string']);
        if (empty($data['items'][0])  ||  count($data['items'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }

        if (!empty($data['items'])) {

            $data['items'] = DB::table('items')
                ->select(
                    'items.*',
                    'item_categories.*',
                )
                ->leftJoin('item_categories', 'item_categories.item_category_id', 'items.item_category_id')
                ->where('items.user_id',  Auth::id())
                ->whereIn('items.item_id', $data['items'])
                ->orderBy($sort, $order_by)
                ->get();


            $user = DB::table('users')->where('user_id', Auth::id())->first();
            $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


            foreach ($data['items'] as $key => $tax) {
                $data['items'][$key]->created_at =  !empty($tax->created_at) ? getTimeDateDisplay($user->time_zone_id, $tax->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
                $data['items'][$key]->updated_at =  !empty($tax->updated_at) ? getTimeDateDisplay($user->time_zone_id, $tax->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            }
        }


        return view('pages/item.list', compact('data'));
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

        return view('pages/item.add', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'item_name' => 'required|string|max:100',
                'sku'          => 'nullable|unique:items,sku,' . $request->item_code . ',item_code',
                'item_category_id' => 'required',
                'hsn_sac' => 'required',
                'item_type' => 'required',
                'unit_price' => 'required|decimal:0,2',
                'cost_price' => 'nullable|decimal:0,2',
                'selling_price' => 'nullable|decimal:0,2',

                'stock' => 'required',
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

            $item_id =  DB::table('items')->insertGetId([
                'item_name'   => $request->input('item_name'),
                'description'   => $request->input('description'),
                'user_id'     => Auth::id(),
                'item_code'   => $this->generateUniqueItemCode(),
                'item_category_id'   => $request->input('item_category_id'),
                'sku'         => $request->input('sku') ?? '',
                'hsn_sac'     => $request->input('hsn_sac') ?? '',
                'item_type'   => $request->input('item_type'),
                'unit_price'  => $request->input('unit_price') ?? 0,
                'cost_price'       => $request->input('cost_price') ?? NULL,
                'selling_price'       => $request->input('selling_price') ?? NULL,
                'stock'       => $request->input('stock') ?? 0,
                'status'      => $request->input('status') ?? 'Y',
                'tax_id'      => $request->input('tax_id') ?? null,
                'discount_id' => $request->input('discount_id') ?? null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);


            return response()->json([
                'error' => 0,
                'message' => 'Item added Successfully!',
                'item_id' =>  $item_id
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

        $data['item'] = ItemModel::where('user_id', Auth::id())
            ->where('item_code', $request->input('item_code'))
            ->first();

        if (empty($data['item'])) {
            return abort(404);
        }


        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();

        $data['item_categories'] = \DB::table('item_categories')
            ->where('user_id',  Auth::id())
            ->orderBy('item_category_name', 'ASC')->get();

        return view('pages/item.edit', compact('data'));
    }



    public function update(Request $request)
    {


        try {


            $validator = Validator::make($request->all(), [
                'item_name' => 'required|string|max:100',
                'hsn_sac' => 'required',
                'item_category_id' => 'required',
                'item_type' => 'required',
                'unit_price' => 'required|decimal:0,2',
                'cost_price' => 'nullable|decimal:0,2',
                'selling_price' => 'nullable|decimal:0,2',


                'stock' => 'required',
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

            DB::table('items')
                ->where('item_code',  $request->input('item_code'))
                ->update([
                    'item_name'   => $request->input('item_name'),
                    'description'   => $request->input('description'),
                    'item_category_id'   => $request->input('item_category_id'),
                    'user_id'     => Auth::id(),
                    'sku'         => $request->input('sku') ?? '',
                    'hsn_sac'     => $request->input('hsn_sac') ?? '',
                    'item_type'   => $request->input('item_type'),
                    'unit_price'  => $request->input('unit_price') ?? 0,
                    'stock'       => $request->input('stock') ?? 0,
                    'cost_price'       => $request->input('cost_price') ?? NULL,
                    'selling_price'       => $request->input('selling_price') ?? NULL,
                    'status'      => $request->input('status') ?? 'Y',
                    'tax_id'      => $request->input('tax_id') ?? null,
                    'discount_id' => $request->input('discount_id') ?? null,
                ]);

            return response()->json([
                'error' => 0,
                'message' => 'Item Updated Successfully!',
                'item_code' => $request->item_code
            ]);
        } catch (\Exception $e) {

            \Log::channel('info')->error('error while updating item: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while updating the item.'
            ], 500);
        }
    }



    public function destroy(Request $request)
    {
        // Check if it's bulk delete (array) or single delete (single id)
        $ids = $request->input('ids');

        if (is_array($ids)) {
            // Bulk delete
            ItemModel::where('user_id',  Auth::id())
                ->whereIn('item_code', $ids)
                ->delete();
        } elseif (is_numeric($ids)) {
            // Single delete
            ItemModel::where('user_id', Auth::id())
                ->where('item_code', $ids) // only if $ids is a single ID
                ->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item(s) deleted successfully.'
        ]);
    }


    private function generateUniqueItemCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\ItemModel::where('item_code', $code)->exists());

        return $code;
    }


    public function search(Request $request)
    {
        $query = $request->get('query', '');

        // Example: search by name or code; limit to 20 results
        $results = DB::table('items')
            ->leftJoin('item_categories', 'items.item_category_id', '=', 'item_categories.item_category_id')
            ->leftJoin('taxes', 'items.tax_id', '=', 'taxes.tax_id')
            ->leftJoin('discounts', 'items.discount_id', '=', 'discounts.discount_id')
            ->where('items.user_id', auth()->id())
            ->where(function ($q) use ($query) {
                $q->where('items.item_name', 'LIKE', "%{$query}%")
                    ->orWhere('items.sku', 'LIKE', "%{$query}%")
                    ->orWhere('items.hsn_sac', 'LIKE', "%{$query}%");
            })
            ->select(
                'items.item_id',
                'items.item_name',
                'items.description',
                'items.hsn_sac',
                'items.sku',
                'items.unit_price',
                'items.stock',
                'item_categories.item_category_name',
                'taxes.name as tax_name',
                'taxes.percent as tax_percent',
                'taxes.tax_id',
                'discounts.name as discount_name',
                'discounts.percent as discount_percent',
                'discounts.discount_id',
            )
            ->take(20)
            ->get();


        $output = '';
        if ($results->count() > 0) {
            $output .= '<div class="p-3 rounded shadow-sm border" style="max-height: 400px; overflow-y:auto; border:1px solid #dee2e6; background-color:#f8f9fa;">';
            foreach ($results as $result) {
                $output .= '
        <a href="javascript:void(0);"
           class="list-group-item list-group-item-action select-item d-flex justify-content-between align-items-center p-3 mb-2 rounded shadow-sm"
           data-item_id="' . $result->item_id . '"
           data-item_name="' . htmlspecialchars($result->item_name) . '"
           data-description="' . htmlspecialchars($result->description) . '"
           data-hsn_sac="' . htmlspecialchars($result->hsn_sac) . '"
           data-unit_price="' . htmlspecialchars($result->unit_price) . '"
           data-tax_id="' . htmlspecialchars($result->tax_id) . '"
           data-discount_id="' . htmlspecialchars($result->discount_id) . '"
           style="cursor:pointer; transition: all 0.2s ease-in-out;">

           <div>
               <h6 class="mb-1 fw-bold text-dark">
                   <i class="bi bi-box me-1"></i> ' . htmlspecialchars($result->item_name) . '
               </h6>
               <p class="mb-0 text-muted small">
                   <i class="bi bi-upc-scan me-1"></i> HSN/SAC: ' . htmlspecialchars($result->hsn_sac) . '
               </p>
               <p class="mb-0 text-muted small">
                   <i class="bi bi-currency-rupee me-1"></i> ' . htmlspecialchars($result->unit_price) . '
               </p>
           </div>
           <div class="text-end d-flex flex-column align-items-end">
               <span class="badge bg-info mb-1 text-white">
                   <i class="fas fa-percentage me-1 text-white"></i> Tax: ' . intval($result->tax_percent ?? 0) . '%
               </span>
               <span class="badge bg-warning text-white">
                   <i class="fas fa-tags me-1 text-white"></i> Discount: ' . intval($result->discount_percent ?? 0) . '%
               </span>
           </div>
        </a>';
            }
            $output .= '</div>';
        } else {
            $output .= '<div class="list-group-item text-muted text-center">No Product Found</div>';
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
