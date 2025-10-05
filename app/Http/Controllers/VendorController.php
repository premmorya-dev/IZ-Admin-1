<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorModel;



class VendorController extends Controller
{


    public function search(Request $request)
    {


        $query = $request->get('query');


        $vendors = DB::table('vendors')
            ->where('vendors.user_id', auth()->id())
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('vendors.vendor_name', 'LIKE', "%{$query}%")
                    ->orWhere('vendors.company_name', 'LIKE', "%{$query}%")
                    ->orWhere('vendors.email', 'LIKE', "%{$query}%")
                    ->orWhere('vendors.phone', 'LIKE', "%{$query}%")
                    ->orWhere('vendors.gst_number', 'LIKE', "%{$query}%");
            })
            ->select(
                'vendors.vendor_name',
                'vendors.company_name',
                'vendors.email',
                'vendors.phone',
                'vendors.gst_number',
                'vendors.address_1',

            )
            ->take(5)
            ->get();


        return response()->json($vendors);
    }

    public function searchvendor(Request $request)
    {
        $query = $request->input('query');

        $vendors = vendorModel::where('user_id', auth()->id())
            ->where('vendor_name', 'LIKE', "%$query%")
            ->where('status', 'active')
            ->limit(10)
            ->get();


        $output = '';
        if ($vendors->count() > 0) {
            foreach ($vendors as $vendor) {
                $output .= '<a href="#" class="list-group-item list-group-item-action vendor-item" data-id="' . $vendor->vendor_id . '" data-name="' . htmlspecialchars($vendor->vendor_name) . '">' . htmlspecialchars($vendor->vendor_name) . '</a>';
            }
        } else {
            $output .= '<div class="list-group-item">No vendor Found</div>';
        }

        return response($output);
    }

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
            'vendor_id' => 'vendors.vendor_id',
            'vendor_name' => 'vendors.vendor_name',
            'company_name' => 'vendors.company_name',
            'email' => 'vendors.email',
            'phone' => 'vendors.phone',
            'gst_number' => 'vendors.gst_number',
            'state_id' => 'vendors.state_id',
            'country_id' => 'vendors.country_id',
            'zip' => 'vendors.zip',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'vendors.vendor_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('vendors')
                ->select(
                    'vendors.vendor_id',
                );


            $query->where('vendors.user_id', '=', Auth::id());

            // **Applying Filters**

            if ($request->filled('vendor_name')) {
                $query->where('vendors.vendor_name', 'LIKE',"%". $request->input('vendor_name') . '%' );
            }

            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('vendors.status', $status);
            }


            if ($request->filled('company_name')) {
                $query->where('vendors.company_name', 'LIKE', '%' . $request->input('company_name') . '%');
            }


            if ($request->filled('email')) {
                $query->where('vendors.email', 'LIKE', '%' . $request->input('email') . '%');
            }





            if ($request->filled('phone')) {
                $query->where('vendors.phone', '=', $request->input('phone'));
            }
            if ($request->filled('gst_number')) {
                $query->where('vendors.gst_number', '=', $request->input('gst_number'));
            }


            if ($request->filled('country_id')) {
                $country_id = explode(',', $request->input('country_id'));
                $query->whereIn('vendors.country_id', $country_id);
            }

            if ($request->filled('state_id')) {
                $state_id = explode(',', $request->input('state_id'));
                $query->whereIn('vendors.state_id', $state_id);
            }



            if ($request->filled('created_at')) {
                $created_at = parseDateRange($request->input('created_at'));

                $query->where('vendors.created_at', '>=', convertToUTC($created_at['start_date']));
                $query->where('vendors.created_at', '<=', convertToUTC($created_at['end_date']));
            }


            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['vendor_string'] = implode(",", array_column($query, 'vendor_id'));
        } else {

            $query = DB::table('vendors')
                ->select(
                    'vendors.vendor_id',
                );

            $query->where('vendors.user_id', '=', Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['vendor_string'] = implode(",", array_column($query, 'vendor_id'));
        }

        $data['vendors'] = explode(",", $data['vendor_string']);
        if (empty($data['vendors'][0])  ||  count($data['vendors'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }


        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();
        if (!empty($data['vendors'])) {

            $data['vendors'] = DB::table('vendors')
                ->select(
                    'vendors.*',

                )
                ->where('vendors.user_id', '=', Auth::id())
                ->whereIn('vendors.vendor_id', $data['vendors'])
                ->orderBy($sort, $order_by)
                ->get();





            foreach ($data['vendors'] as $key => $vendor) {


                $data['vendors'][$key]->created_at_utc = $vendor->created_at;
                $data['vendors'][$key]->created_at =  !empty($vendor->created_at) ? getTimeDateDisplay($user->time_zone_id, $vendor->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                $data['vendors'][$key]->updated_at_utc = $vendor->updated_at;
                $data['vendors'][$key]->updated_at =  !empty($vendor->updated_at) ? getTimeDateDisplay($user->time_zone_id, $vendor->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            }
        }


        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();

        return view('pages/vendor.list', compact('data'));
    }


    public function add(Request $request)
    {
        $data = [];

        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();


        $data['setting'] = \DB::table('settings')->where('user_id', Auth::id())->first();

        if (!empty($data['setting'])) {
            $data['setting']->country = \DB::table('countries')->where('country_id',  $data['setting']->country_id)->first();
            $data['setting']->state = \DB::table('country_states')->where('state_id',  $data['setting']->state_id)->first();
        }


        return view('pages/vendor.add', compact('data'));
    }

    public function store(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'vendor_name' => 'required|string|max:100',
                'company_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'gst_number' => 'nullable|string|max:50',
                'address_1' => 'required|string',
                'address_2' => 'nullable|string',
                'city' => 'nullable|string|max:100',
                'state_id' => 'required|integer',
                'country_id' => 'required|integer',
                'currency_code' => 'required',
                'zip' => 'nullable|string|max:20',
                'notes' => 'nullable|string',
                'terms' => 'nullable|string',
                'status' => 'nullable|in:active,deactive',
            ], [
                'vendor_name.required' => 'vendor name is required.',
                'vendor_name.max' => 'vendor name should not exceed 100 characters.',
                'company_name.max' => 'Company name should not exceed 255 characters.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'Email should not exceed 255 characters.',
                'phone.max' => 'Phone number should not exceed 20 characters.',
                'gst_number.max' => 'GST number should not exceed 50 characters.',
                'city.max' => 'City name should not exceed 100 characters.',
                'zip.max' => 'Zip code should not exceed 20 characters.',
                'status.in' => 'Status must be either active or deactive.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            $userId = Auth::id(); // Get currently authenticated user ID

            // Create vendor
            $vendor = vendorModel::create([
                'user_id' => $userId,
                'vendor_name' => $data['vendor_name'] ? ucfirst($data['vendor_name']) : null,
                'vendor_code' => $this->generateUniquevendorCode(),
                'company_name' => $data['company_name'] ? ucfirst($data['company_name']) : null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'gst_number' => $data['gst_number'] ?? null,
                'address_1' => $data['address_1'] ?? null,
                'address_2' => $data['address_2'] ?? null,
                'city' => $data['city'] ?? null,
                'state_id' => $data['state_id'] ?? null,
                'country_id' => $data['country_id'] ?? null,
                'currency_code' => $data['currency_code'] ?? null,
                'zip' => $data['zip'] ?? null,
                'notes' => $data['notes'] ?? null,
                'terms' => $data['terms'] ?? null,
                'status' => $data['status'] ?? 'active', // default 'active'
            ]);

            return response()->json([
                'error' => 0,
                'message' => 'vendor Saved Successfully!',
                'vendor_id' => $vendor->vendor_id
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('error while preparing vendor: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::channel('admin')->error('error while saving vendor: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while saving the vendor.'
            ], 500);
        }
    }


    public function edit(Request $request)
    {

        $data = [];

        $data['vendor'] = vendorModel::where('vendor_code', $request->input('vendor_code'))
            ->where('user_id', auth()->id())
            ->first();

        if (empty($data['vendor'])) {
            return abort(404);
        }



        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();


        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();

        return view('pages/vendor.edit', compact('data'));
    }




    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'vendor_name' => 'required|string|max:100',
                'company_name' => 'nullable|string|max:255',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:20',
                'gst_number' => 'nullable|string|max:50',
                'address_1' => 'required|string',
                'address_2' => 'nullable|string',
                'city' => 'nullable|string|max:100',
                'state_id' => 'required|integer',
                'country_id' => 'required|integer',
                'currency_code' => 'required',
                'zip' => 'nullable|string|max:20',
                'notes' => 'nullable|string',
                'status' => 'nullable|in:active,deactive',
            ], [
                'vendor_name.required' => 'vendor name is required.',
                'vendor_name.max' => 'vendor name should not exceed 100 characters.',
                'company_name.max' => 'Company name should not exceed 255 characters.',
                'email.email' => 'Please enter a valid email address.',
                'email.max' => 'Email should not exceed 255 characters.',
                'phone.max' => 'Phone number should not exceed 20 characters.',
                'gst_number.max' => 'GST number should not exceed 50 characters.',
                'city.max' => 'City name should not exceed 100 characters.',
                'zip.max' => 'Zip code should not exceed 20 characters.',
                'status.in' => 'Status must be either active or deactive.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            $vendor = vendorModel::where('vendor_code', $request->vendor_code)->firstOrFail();


            $vendor->update([
                'vendor_name' => $data['vendor_name'] ? ucfirst($data['vendor_name']) : null,
                'company_name' => $data['company_name'] ? ucfirst($data['company_name']) : null,
                'email' => $data['email'] ?? null,
                'phone' => $data['phone'] ?? null,
                'gst_number' => $data['gst_number'] ?? null,
                'address_1' => $data['address_1'] ?? null,
                'address_2' => $data['address_2'] ?? null,
                'city' => $data['city'] ?? null,
                'state_id' => $data['state_id'] ?? null,
                'country_id' => $data['country_id'] ?? null,
                'currency_code' => $data['currency_code'] ?? null,
                'zip' => $data['zip'] ?? null,
                'notes' => $data['notes'] ?? null,
                'status' => $data['status'] ?? 'active',
            ]);

            return response()->json([
                'error' => 0,
                'message' => 'Vendor Updated Successfully!',
                'vendor_code' => $request->vendor_code
            ]);
        } catch (\Exception $e) {
            \Log::channel('info')->error('error while updating vendor: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while updating the vendor.'
            ], 500);
        }
    }



    public function destroy(Request $request)
    {
        // Check if it's bulk delete (array) or single delete (single id)
        $ids = $request->input('ids');

        if (is_array($ids)) {
            // Bulk delete
            VendorModel::whereIn('vendor_code', $ids)
                ->where('user_id', auth()->id())
                ->delete();
        } elseif (is_numeric($ids)) {
            // Single delete
            VendorModel::where('vendor_code', $ids)
                ->where('user_id', auth()->id())
                ->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'vendor(s) deleted successfully.'
        ]);
    }

    private function generateUniquevendorCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\vendorModel::where('vendor_code', $code)->exists());

        return $code;
    }
}
