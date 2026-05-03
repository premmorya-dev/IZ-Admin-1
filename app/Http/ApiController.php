<?php

namespace App\Http;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\ValidationException;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    public function register(Request $request)
    {
        try {

            $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|max:100|unique:users,email',
                'password' => 'required|confirmed|min:8',
                // 'mobile_country_code_id' => 'required|numeric',
                // 'mobile_no' => ['required', 'regex:/^[6-9]\d{9}$/'],
                // 'terms' => ['accepted'],
            ], [
                'mobile_no.regex' => 'The mobile number must be a valid 10-digit Indian number starting with 6, 7, 8, or 9.',
            ]);


            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                // 'mobile_country_code_id' => $request->mobile_country_code_id,
                // 'mobile_no' => $request->mobile_no,
                'last_login_datetime' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp(),
                'password' => Hash::make($request->password),
            ]);




            // event(new Registered($user));

            $payload = [
                'iss' => 'https://invoicezy.com',
                'sub' => $user->user_id,
                'iat' => time(),
                'exp' => time() + 3600
            ];

            $jwt = JWT::encode($payload, config('app.jwt_secret'), 'HS256');


            $url = 'https://pro.invoicezy.com/auth/callback?token=' . $jwt;



            // ✅ Success Response
            return response()->json([
                'status' => true,
                'message' => 'User registered successfully',
                'data' => [
                    'id' => $user->user_id,
                    'email' => $user->email,
                    'url' => $url
                ]
            ], 201);
        } catch (ValidationException $e) {

            // ❌ Validation Error Response
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {

            // ❌ General Error Response
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage() // production me hide karna
            ], 500);
        }
    }


    public function plans()
    {
        $plans = DB::table('plans')->get();

        return  response()->json($plans, 200);
    }


    public function contact(Request $request)
    {
        // ✅ Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string',
        ]);

        // ❌ Validation failed
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            // ✅ Insert using Query Builder
            $contactId = DB::table('contacts')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // ✅ Success Response
            return response()->json([
                'status' => true,
                'message' => 'Your message has been sent successfully.',              
            ], 201);
        } catch (\Exception $e) {
            // ❌ Server error
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
