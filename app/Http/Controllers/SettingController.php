<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
// use App\Models\InvoiceModel;
use App\Models\SettingModel;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
// use Barryvdh\DomPDF\Facade\Pdf;
// use ZipArchive;


class SettingController extends Controller
{




    public function edit()
    {



        $id = Auth::id();

        $setting = \DB::table('settings')->select('setting_id')->where('user_id', $id)->first();

        $data['setting'] = SettingModel::findOrFail($setting->setting_id);



        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = \DB::table('templates')->orderBy('template_name', 'ASC')->get();

        $data['discounts'] = \DB::table('discounts')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();



        $data['taxes'] = \DB::table('taxes')
            ->where('user_id',  Auth::id())
            ->orderBy('name', 'ASC')->get();

        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();

        $data['mobile_country_list'] = \DB::table('mobile_country_list')->orderBy('country_name', 'ASC')->get();

        $data['upi_payment_id'] = \DB::table('upi_payment_id')->where('user_id',  Auth::id())->orderBy('upi_name', 'ASC')->get();



        return view('pages/settings.edit', compact('data'));
    }


    public function account()
    {



        $id = Auth::id();
        $setting = \DB::table('settings')->select('setting_id')->where('user_id', $id)->first();

        $data['setting'] = SettingModel::findOrFail($setting->setting_id);

        $data['currencies'] = \DB::table('currencies')->orderBy('currency_name', 'ASC')->get();
        $data['templates'] = \DB::table('templates')->orderBy('template_name', 'ASC')->get();

        $data['taxes'] = \DB::table('taxes')->orderBy('name', 'ASC')->get();
        $data['discounts'] = \DB::table('discounts')->orderBy('name', 'ASC')->get();

        $data['countries'] = \DB::table('countries')->orderBy('country_name', 'ASC')->get();
        $data['states'] = \DB::table('country_states')->orderBy('state_name', 'ASC')->get();

        $data['mobile_country_list'] = \DB::table('mobile_country_list')->orderBy('country_name', 'ASC')->get();

        $data['upi_payment_id'] = \DB::table('upi_payment_id')->orderBy('upi_name', 'ASC')->get();



        return view('pages/settings.account', compact('data'));
    }


    public function updateAccount(Request $request)
    {
        $id = Auth::id();

        $user = Auth::user();
        $validator = Validator::make($request->all(), [

            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:191|unique:users,email,' . $user->user_id . ',user_id',
            'current_password' => 'nullable|required_with:new_password,confirm_password|string',
            'new_password' => 'nullable|required_with:current_password,confirm_password|string|min:8|different:current_password',
            'confirm_password' => 'nullable|required_with:new_password|same:new_password',


            'company_name' => 'required|string|max:100',
            'pincode' => 'nullable|string|max:10',
            'state_id' => 'required|integer',
            'country_id' => 'required|integer',
            'is_company' => 'required|in:Y,N',
        ], [

            'state_id.required' => 'Please select a state.',
            'country_id.required' => 'Please select a country.',
            'is_company.required' => 'Please indicate if you are representing a company.',
            'is_company.in' => 'Invalid value for company status.',
        ]);

        if ($validator->fails()) {

            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();


        // Update user details
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();


        $setting = SettingModel::where('user_id', $id)->first();


        // === Update Settings ===
        SettingModel::where('user_id', $id)->update([
            'default_currency' => $data['default_currency'] ?? null,
            'company_name' => $data['company_name'],
            'is_company' => $data['is_company'],
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'state_id' => $data['state_id'],
            'country_id' => $data['country_id'],
            'pincode' => $data['pincode'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Account updated successfully!');
    }

    public function update(Request $request)
    {
        $id = Auth::id();


        $validator = Validator::make($request->all(), [
            'mobile_no' => 'required|string|max:15',
            'mobile_country_code_id' => 'required|string|max:5',
            'company_name' => 'required|string|max:100',
            'pagination_limit' => 'required|integer|min:1|max:100',
            'default_tax_id' => 'nullable|numeric|min:0|max:100',
            'default_discount_id' => 'nullable|numeric|min:0|max:100',
            'pincode' => 'nullable|string|max:10',
            'default_currency' => 'nullable|string|max:10',
            'invoice_prefix' => 'nullable|string|max:50',
            'estimate_prefix' => 'nullable|string|max:50',
            'expense_prefix' => 'nullable|string|max:50',
            'state_id' => 'required|integer',
            'country_id' => 'required|integer',
            'is_company' => 'required|in:Y,N',
            'default_upi_id' => 'nullable',
            'date_format' => 'required',
            'logo_path' => 'nullable|mimes:jpg,jpeg,png,webp|max:100',
            'signature' => 'nullable|mimes:jpg,jpeg,png,webp|max:100'

        ]);

        $validator->setAttributeNames([
            'logo_path' => 'company logo',
            'signature' => 'digital signature',
        ]);

        if ($validator->fails()) {

            return back()
                ->withErrors($validator)
                ->withInput($request->except(['logo_path', 'signature']));
        }

        $data = $validator->validated();


        $setting = SettingModel::where('user_id', $id)->first();

        // === Handle Logo Removal ===
        if ($request->has('remove_logo_path') && $request->input('remove_logo_path') == '1') {
            if ($setting && $setting->logo_path && file_exists(public_path($setting->logo_path))) {
                unlink(public_path($setting->logo_path)); // delete old file
            }
            $data['logo_path'] = null;
        } elseif ($request->hasFile('logo_path')) {
            $file = $request->file('logo_path');
            $path = public_path("storage/users/logo");

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);

            $data['logo_path'] = "storage/users/logo/{$filename}";
        } else {

            if ($setting && $setting->logo_path && file_exists(public_path($setting->logo_path))) {
                $data['logo_path'] = $setting->logo_path;
            } else {
                $data['logo_path'] = NULL;
            }
        }

        // === Handle Signature Removal ===
        if ($request->has('remove_signature') && $request->input('remove_signature') == '1') {
            if ($setting && $setting->signature && file_exists(public_path($setting->signature))) {
                unlink(public_path($setting->signature)); // delete old file
            }
            $data['signature'] = null;
        } elseif ($request->hasFile('signature')) {
            $file = $request->file('signature');
            $path = public_path("storage/users/signature");

            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }

            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($path, $filename);

            $data['signature'] = "storage/users/signature/{$filename}";
        } else {

            if ($setting && $setting->signature && file_exists(public_path($setting->signature))) {
                $data['signature'] = $setting->signature;
            } else {
                $data['signature'] = NULL;
            }
        }

        SettingModel::where('user_id', $id)->update([
            'logo_path' => $data['logo_path'],
            'signature' => $data['signature'],
            'default_tax_id' => $data['default_tax_id'] ?? null,
            'default_upi_id' => $data['default_upi_id'] ?? null,
            'default_discount_id' => $data['default_discount_id'] ?? null,
            'invoice_prefix' => $data['invoice_prefix'] ?? null,
            'estimate_prefix' => $data['estimate_prefix'] ?? null,
            'expense_prefix' => $data['expense_prefix'] ?? null,
            'notes' => $request->input('notes') ?? null,
            'terms' => $request->input('terms') ?? null,
            'invoice_start_number' => $request->input('invoice_start_number'),
            'display_gst_number' => $request->input('display_gst_number') ?? 'N' ,
            'user_gst_number' => $request->input('user_gst_number') ?? Null ,
            'company_footer' => $request->input('company_footer'),
            'pagination_limit' => $data['pagination_limit'],
            'company_name' => $data['company_name'],
            'is_company' => $data['is_company'],
            'address_1' => $request->input('address_1'),
            'address_2' => $request->input('address_2'),
            'state_id' => $data['state_id'],
            'country_id' => $data['country_id'],
            'pincode' => $data['pincode'] ?? null,
            'date_format' =>  $request->input('date_format') ?? 'd-m-Y',
            'invoice_payment_reminder_status' => $request->input('invoice_payment_reminder_status'),
            'reminder_before_due_days' => empty($request->input('reminder_before_due_days')) ||  $request->input('reminder_before_due_days') == '0' ?  Null :  $request->input('reminder_before_due_days'),
            'everyday_reminder_after_due_day' => $request->input('everyday_reminder_after_due_day') == 'on' ? 'Y' : 'N',

            'shipping_status' => $request->input('shipping_status'),
        ]);


        User::where('user_id', $id)->update([
            'mobile_no' => $data['mobile_no'],
            'mobile_country_code_id' => $data['mobile_country_code_id'],
            'time_zone_id' => 28,
        ]);


        return redirect()->back()->with('success', 'Settings updated successfully!');
    }



    public function getStates(Request $request)
    {
        $country_id = $request->get('country_id');

        $states = \DB::table('country_states')
            ->where('country_id', $country_id)
            ->orderBy('state_name', 'ASC')
            ->get();

        return response()->json(['states' => $states]);
    }

    public static function getCompanyImage($type = 'url')
    {
        $userId =   Auth::id();

        if (empty($userId) ||  !$userId || is_null($userId)) {
            throw new \Exception("Setting not found for user: " . $userId);
        }

        // Try to find the company settings by user ID
        $setting = SettingModel::where('user_id', $userId)->first();

        // Check if the setting and image exist
        if ($setting && !empty($setting->logo_path)) {
            return asset($setting->logo_path);
        }


        if ($type == 'path') {
            return $setting->logo_path;
        }
        // Return default image path
        return asset('logo.png');
    }
}
