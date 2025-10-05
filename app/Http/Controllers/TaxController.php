<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\TaxModel;



class TaxController extends Controller
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
            'tax_id' => 'taxes.tax_id',
            'name' => 'taxes.name',
            'percent' => 'taxes.percent',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'taxes.tax_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('taxes')
                ->select(
                    'taxes.tax_id',
                );

            $query->where('taxes.user_id',  Auth::id());


            // **Applying Filters**



            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('taxes.status', $status);
            }


            if ($request->filled('name')) {
                $query->where('taxes.name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if ($request->filled('percent')) {
                $query->where('taxes.percent', '=',  $request->input('percent'));
            }






            if ($request->filled('created_at')) {
                $created_at = parseDateRange($request->input('created_at'));

                $query->where('taxes.created_at', '>=', convertToUTC($created_at['start_date']));
                $query->where('taxes.created_at', '<=', convertToUTC($created_at['end_date']));
            }


            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['tax_string'] = implode(",", array_column($query, 'tax_id'));
        } else {

            $query = DB::table('taxes')
                ->select(
                    'taxes.tax_id',
                );

            $query->where('taxes.user_id',  Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['tax_string'] = implode(",", array_column($query, 'tax_id'));
        }

        $data['taxes'] = explode(",", $data['tax_string']);
        if (empty($data['taxes'][0])  ||  count($data['taxes'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }

        if (!empty($data['taxes'])) {

            $data['taxes'] = DB::table('taxes')
                ->select(
                    'taxes.*',

                )
                ->where('taxes.user_id',  Auth::id())
                ->whereIn('taxes.tax_id', $data['taxes'])
                ->orderBy($sort, $order_by)
                ->get();


            $user = DB::table('users')->where('user_id', Auth::id())->first();
            $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


            foreach ($data['taxes'] as $key => $tax) {


                $data['taxes'][$key]->created_at_utc = $tax->created_at;
                $data['taxes'][$key]->created_at =  !empty($tax->created_at) ? getTimeDateDisplay($user->time_zone_id, $tax->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            }
        }


        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();

        return view('pages/tax.list', compact('data'));
    }


    public function create(Request $request)
    {
        $data = [];

        return view('pages/tax.add', compact('data'));
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


            $tax = TaxModel::create([
                'name' => $data['name'],
                'user_id' => Auth::id(),
                'tax_code' => $this->generateUniqueTaxCode(),
                'status' => $data['status'] ?? null,
                'percent' => $data['percent'] ?? null,
            ]);

            return response()->json([
                'error' => 0,
                'message' => 'Tax added Successfully!',
                'data'    => [
                    'tax_id' => $tax->tax_id,
                    'tax_code' => $tax->tax_code,
                    'name'   => $tax->name,
                    'percent' => $tax->percent,
                    'status' => $tax->status,
                ]
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('error while preparing tax: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::channel('admin')->error('error while saving tax: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while saving the tax.'
            ], 500);
        }
    }



    public function edit(Request $request)
    {


        $data = [];

        $data['tax'] = TaxModel::where('user_id', Auth::id())
            ->where('tax_code', $request->input('tax_code'))
            ->first();

        if (empty($data['tax'])) {
            return abort(404);
        }




        return view('pages/tax.edit', compact('data'));
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

            $tax = TaxModel::where('user_id', Auth::id())
                ->where('tax_id', $request->input('tax_id')) // or tax_code if you use that
                ->firstOrFail();

            $tax->update([
                'name'    => $data['name'],
                'status'  => $data['status'] ?? null,
                'percent' => $data['percent'] ?? null,
            ]);


            return response()->json([
                'error' => 0,
                'message' => 'Tax Updated Successfully!',
                'tax_id' => $request->input('tax_code')
            ]);
        } catch (\Exception $e) {
            \Log::channel('info')->error('error while updating tax: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while updating the tax.'
            ], 500);
        }
    }



    public function destroy(Request $request)
    {
        // Check if it's bulk delete (array) or single delete (single id)
        $ids = $request->input('ids');

        if (is_array($ids)) {
            // Bulk delete

            TaxModel::where('user_id',  Auth::id())
                ->whereIn('tax_id', $ids)
                ->delete();
        } elseif (is_numeric($ids)) {
            // Single delete
            TaxModel::where('user_id', Auth::id())
                ->where('tax_id', $ids) // only if $ids is a single ID
                ->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Client(s) deleted successfully.'
        ]);
    }


    private function generateUniqueTaxCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\TaxModel::where('tax_code', $code)->exists());

        return $code;
    }
}
