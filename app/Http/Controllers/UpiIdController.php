<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\UpiIdModel;
use Illuminate\Support\Facades\Log;



class UpiIdController extends Controller
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
            'upi_log_id' => 'upi_payment_id.upi_log_id',
            'upi_name' => 'upi_payment_id.name',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'upi_payment_id.upi_log_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('upi_payment_id')
                ->select(
                    'upi_payment_id.upi_log_id',
                );

            $query->where('upi_payment_id.user_id',  Auth::id());


            // **Applying Filters**



            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('upi_payment_id.status', $status);
            }


            if ($request->filled('name')) {
                $query->where('upi_payment_id.name', 'LIKE', '%' . $request->input('name') . '%');
            }

            if ($request->filled('upi_name')) {
                $query->where('upi_payment_id.upi_name', 'LIKE', '%' . $request->input('upi_name') . '%');
            }





            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['upi_id_string'] = implode(",", array_column($query, 'upi_log_id'));
        } else {

            $query = DB::table('upi_payment_id')
                ->select(
                    'upi_payment_id.upi_log_id',
                );

            $query->where('upi_payment_id.user_id',  Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['upi_id_string'] = implode(",", array_column($query, 'upi_log_id'));
        }

        $data['upi_payment_id'] = explode(",", $data['upi_id_string']);
        if (empty($data['upi_payment_id'][0])  ||  count($data['upi_payment_id'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }

        if (!empty($data['upi_payment_id'])) {

            $data['upi_payment_id'] = DB::table('upi_payment_id')
                ->select(
                    'upi_payment_id.*',

                )
                ->where('upi_payment_id.user_id',  Auth::id())
                ->whereIn('upi_payment_id.upi_log_id', $data['upi_payment_id'])
                ->orderBy($sort, $order_by)
                ->get();
        }


        return view('pages/upi_id.list', compact('data'));
    }


    public function create(Request $request)
    {
        $data = [];

        return view('pages/upi_id.add', compact('data'));
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'upi_name' => 'required|string|max:100',
                'upi_id' => 'required|string|unique:upi_payment_id,upi_id',
                'status' => 'required',
               

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


            $tax = UpiIdModel::create([
                'upi_name' => $data['upi_name'],
                'user_id' => Auth::id(),
                'status' => $data['status'] ?? null,
                'upi_id' => $data['upi_id'] ?? null,
            ]);

            return response()->json([
                'error' => 0,
                'message' => 'Upi added Successfully!',
                'upi_log_id' => $tax->upi_log_id
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('error while preparing upi id: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            dd($e->getMessage());
            Log::channel('admin')->error('error while saving upi id: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while saving the upi id.'
            ], 500);
        }
    }



    public function edit(Request $request, $upi_log_id)
    {


        $data = [];

        $data['upi_id'] = UpiIdModel::where('user_id', Auth::id())
            ->where('upi_log_id', $upi_log_id)
            ->first();

        if (empty($data['upi_id'])) {
            return abort(404);
        }




        return view('pages/upi_id.edit', compact('data'));
    }



    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'upi_name' => 'required|string|max:100',
                'upi_id' => 'required|string|unique:upi_payment_id,upi_id',
                'status' => 'required',
                
            ], []);

            if ($validator->fails()) {
                return response()->json([
                    'error'  => 1,
                    'errors' => $validator->errors()
                ], 200);
            }

            $data = $validator->validated();

            $upi_id = UpiIdModel::findOrFail($request->upi_log_id);

            $upi_id->update([
                'upi_name' => $data['upi_name'],
                'user_id' => Auth::id(),
                'status' => $data['status'] ?? null,
                'upi_id' => $data['upi_id'] ?? null,

            ]);

            return response()->json([
                'error' => 0,
                'message' => 'Upi Updated Successfully!',
                'upi_log_id' => $request->upi_log_id
            ]);
        } catch (\Exception $e) {


            Log::channel('info')->error('error while updating tax: ' . $e->getMessage());

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

            UpiIdModel::where('user_id',  Auth::id())
                ->whereIn('upi_log_id', $ids)
                ->delete();
        } elseif (is_numeric($ids)) {
            // Single delete
            UpiIdModel::where('user_id', Auth::id())
                ->where('upi_log_id', $ids) // only if $ids is a single ID
                ->delete();
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid request.'
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Upi Id(s) deleted successfully.'
        ]);
    }
}
