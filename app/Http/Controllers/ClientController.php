<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ClientModel;



class ClientController extends Controller
{


    public function search(Request $request)
    {


        $query = $request->get('query');


        $clients = DB::table('clients')
        ->leftJoin('countries','countries.country_id','clients.country_id')
        ->leftJoin('country_states','country_states.state_id','clients.state_id')
            ->where('clients.user_id', auth()->id())
            ->where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('clients.client_name', 'LIKE', "%{$query}%")
                    ->orWhere('clients.company_name', 'LIKE', "%{$query}%")
                    ->orWhere('clients.email', 'LIKE', "%{$query}%")
                    ->orWhere('clients.phone', 'LIKE', "%{$query}%")
                    ->orWhere('clients.gst_number', 'LIKE', "%{$query}%");
            })
            ->select(
                'clients.*',
                 'countries.country_name',
                 'country_states.state_name',
             

            )
            ->take(5)
            ->get();


        return response()->json($clients);
    }

    public function searchClient(Request $request)
    {
        $query = $request->input('query');

        $clients = ClientModel::where('user_id', auth()->id())
            ->where('client_name', 'LIKE', "%$query%")
            ->where('status', 'active')
            ->limit(10)
            ->get();


        $output = '';
        if ($clients->count() > 0) {
            foreach ($clients as $client) {
                $output .= '<a href="#" class="list-group-item list-group-item-action client-item" data-id="' . $client->client_id . '" data-name="' . htmlspecialchars($client->client_name) . '">' . htmlspecialchars($client->client_name) . '</a>';
            }
        } else {
            $output .= '<div class="list-group-item">No Client Found</div>';
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
            'client_id' => 'clients.client_id',
            'client_name' => 'clients.client_name',
            'company_name' => 'clients.company_name',
            'email' => 'clients.email',
            'phone' => 'clients.phone',
            'gst_number' => 'clients.gst_number',
            'state_id' => 'clients.state_id',
            'country_id' => 'clients.country_id',
            'zip' => 'clients.zip',

        ];

        $order_by = $request->input('direction', 'desc');

        if (!empty($request->input('sort')) && array_key_exists($request->input('sort'), $sort_by)) {
            $sort = $sort_by[$request->input('sort')];
        } else {
            $sort = 'clients.client_id';
        }
        // sorting

        if ($request->has('filters')) {





            $query = DB::table('clients')
                ->select(
                    'clients.client_id',
                );


            $query->where('clients.user_id', '=', Auth::id());

            // **Applying Filters**

            if ($request->filled('client_name')) {
                $query->where('clients.client_name', '=', $request->input('client_name'));
            }

            if ($request->filled('status')) {
                $status = explode(',', $request->input('status'));
                $query->whereIn('clients.status', $status);
            }


            if ($request->filled('company_name')) {
                $query->where('clients.company_name', 'LIKE', '%' . $request->input('company_name') . '%');
            }


            if ($request->filled('email')) {
                $query->where('clients.email', 'LIKE', '%' . $request->input('email') . '%');
            }





            if ($request->filled('phone')) {
                $query->where('clients.phone', '=', $request->input('phone'));
            }
            if ($request->filled('gst_number')) {
                $query->where('clients.gst_number', '=', $request->input('gst_number'));
            }


            if ($request->filled('country_id')) {
                $country_id = explode(',', $request->input('country_id'));
                $query->whereIn('clients.country_id', $country_id);
            }

            if ($request->filled('state_id')) {
                $state_id = explode(',', $request->input('state_id'));
                $query->whereIn('clients.state_id', $state_id);
            }



            if ($request->filled('created_at')) {
                $created_at = parseDateRange($request->input('created_at'));

                $query->where('clients.created_at', '>=', convertToUTC($created_at['start_date']));
                $query->where('clients.created_at', '<=', convertToUTC($created_at['end_date']));
            }


            $result =  $query;

            $data['totalRecords'] =  $result->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);


            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();


            $data['client_string'] = implode(",", array_column($query, 'client_id'));
        } else {

            $query = DB::table('clients')
                ->select(
                    'clients.client_id',
                );

            $query->where('clients.user_id', '=', Auth::id());
            $data['totalRecords'] =  $query->count();
            $data['totalPages'] = ceil($data['totalRecords'] / $data['perPage']);

            $query->orderBy($sort, $order_by);
            $query->offset($data['offset']);
            $query->limit($limit);
            $query = $query->get();
            $query = $query->toArray();
            $data['client_string'] = implode(",", array_column($query, 'client_id'));
        }

        $data['clients'] = explode(",", $data['client_string']);
        if (empty($data['clients'][0])  ||  count($data['clients'])  <= 0) {
            $data['show_pagination'] = false;
        } else {
            $data['show_pagination'] = true;
        }


        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();
        if (!empty($data['clients'])) {

            $data['clients'] = DB::table('clients')
                ->select(
                    'clients.*',

                )
                ->where('clients.user_id', '=', Auth::id())
                ->whereIn('clients.client_id', $data['clients'])
                ->orderBy($sort, $order_by)
                ->get();





            foreach ($data['clients'] as $key => $client) {


                $data['clients'][$key]->created_at_utc = $client->created_at;
                $data['clients'][$key]->created_at =  !empty($client->created_at) ? getTimeDateDisplay($user->time_zone_id, $client->created_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';

                $data['clients'][$key]->updated_at_utc = $client->updated_at;
                $data['clients'][$key]->updated_at =  !empty($client->updated_at) ? getTimeDateDisplay($user->time_zone_id, $client->updated_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
            }
        }


        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();

        return view('pages/client.list', compact('data'));
    }


    public function add(Request $request)
    {
        $data = [];

        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['upi_payment_id'] = \DB::table('upi_payment_id')->orderBy('upi_name', 'ASC')->get();
        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();


        $data['setting'] = \DB::table('settings')->where('user_id', Auth::id())->first();

        if (!empty($data['setting'])) {
            $data['setting']->country = \DB::table('countries')->where('country_id',  $data['setting']->country_id)->first();
            $data['setting']->state = \DB::table('country_states')->where('state_id',  $data['setting']->state_id)->first();
        }


        return view('pages/client.client_form', compact('data'));
    }

    public function store(Request $request)
    {


        try {
            $validator = Validator::make($request->all(), [
                'client_name' => 'required|string|max:100',
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
                'client_name.required' => 'Client name is required.',
                'client_name.max' => 'Client name should not exceed 100 characters.',
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

            // Create client
            $client = ClientModel::create([
                'user_id' => $userId,
                'client_name' => $data['client_name'] ? ucfirst($data['client_name']) : null,
                'client_code' => $this->generateUniqueClientCode(),
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
                'message' => 'Client Saved Successfully!',
                'client_id' => $client->client_id
            ]);
        } catch (ValidationException $e) {
            Log::channel('admin')->error('error while preparing client: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::channel('admin')->error('error while saving client: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while saving the client.'
            ], 500);
        }
    }


    public function edit(Request $request)
    {

        $data = [];

        $data['client'] = ClientModel::where('client_code', $request->input('client_code'))
            ->where('user_id', auth()->id())
            ->first();

        if (empty($data['client'])) {
            return abort(404);
        }



        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();


        $data['upi_payment_id'] = \DB::table('upi_payment_id')->orderBy('upi_name', 'ASC')->get();
        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();

        return view('pages/client.client_form_edit', compact('data'));
    }




    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'client_name' => 'required|string|max:100',
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
                'client_name.required' => 'Client name is required.',
                'client_name.max' => 'Client name should not exceed 100 characters.',
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

            $client = ClientModel::where('client_code', $request->client_code)->firstOrFail();


            $client->update([
                'client_name' => $data['client_name'] ? ucfirst($data['client_name']) : null,
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
                'status' => $data['status'] ?? 'active',
            ]);

            return response()->json([
                'error' => 0,
                'message' => 'Client Updated Successfully!',
                'client_code' => $request->client_code
            ]);
        } catch (\Exception $e) {
            \Log::channel('info')->error('error while updating client: ' . $e->getMessage());

            return response()->json([
                'error' => 1,
                'message' => 'Something went wrong while updating the client.'
            ], 500);
        }
    }



    public function destroy(Request $request)
    {
        // Check if it's bulk delete (array) or single delete (single id)
        $ids = $request->input('ids');

        if (is_array($ids)) {
            // Bulk delete
            ClientModel::whereIn('client_code', $ids)
                ->where('user_id', auth()->id())
                ->delete();
        } elseif (is_numeric($ids)) {
            // Single delete
            ClientModel::where('client_code', $ids)
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
            'message' => 'Client(s) deleted successfully.'
        ]);
    }

    private function generateUniqueClientCode(): string
    {
        do {
            $code = bin2hex(random_bytes(32));
        } while (\App\Models\ClientModel::where('client_code', $code)->exists());

        return $code;
    }
}
