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
use App\Jobs\SendOnboardingEmailJob;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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


            SendOnboardingEmailJob::scheduleFor($user);
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
    private function authCallbackUrl(User $user): string
    {
        $payload = [
            'iss' => 'https://invoicezy.com',
            'sub' => $user->user_id,
            'iat' => time(),
            'exp' => time() + 3600,
        ];

        $jwt = JWT::encode($payload, config('app.jwt_secret'), 'HS256');

        return 'https://pro.invoicezy.com/auth/callback?token=' . $jwt;
    }

    public function googleLogin(Request $request)
    {
        try {
            $request->validate(['access_token' => 'required|string']);
            $accessToken = $request->access_token;

            // 1. Token humare Google client ke liye hi issue hua hai? (token substitution se bachav)
            $info = Http::timeout(10)->get('https://oauth2.googleapis.com/tokeninfo', [
                'access_token' => $accessToken,
            ]);

            if ($info->failed() || $info->json('aud') !== config('services.google.client_id')) {
                return response()->json(['status' => false, 'message' => 'Invalid Google token'], 401);
            }

            // 2. Profile
            $profile = Http::withToken($accessToken)->timeout(10)
                ->get('https://www.googleapis.com/oauth2/v3/userinfo');

            if ($profile->failed()) {
                return response()->json(['status' => false, 'message' => 'Could not fetch Google profile'], 401);
            }

            $g = $profile->json();

            if (empty($g['email']) || empty($g['email_verified'])) {
                return response()->json(['status' => false, 'message' => 'Google email is not verified'], 422);
            }

            // 3. Find or create
            $user = User::where('google_id', $g['sub'])->first()
                ?? User::where('email', $g['email'])->first();

            $isNew = false;

            if ($user) {
                $user->forceFill([
                    'google_id' => $user->google_id ?: $g['sub'],
                    'last_login_datetime' => Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp(),
                ])->save();
            } else {
                $isNew = true;
                $user = User::create([
                    'first_name' => $g['given_name'] ?? Str::before($g['email'], '@'),
                    'last_name' => $g['family_name'] ?? '',
                    'email' => $g['email'],
                    'google_id' => $g['sub'],
                    'password' => Hash::make(Str::random(32)),
                    'last_login_datetime' => Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp(),
                ]);

                SendOnboardingEmailJob::scheduleFor($user);
            }

            return response()->json([
                'status' => true,
                'message' => 'Login successful',
                'data' => [
                    'id' => $user->user_id,
                    'email' => $user->email,
                    'is_new_user' => $isNew,
                    'url' => $this->authCallbackUrl($user),
                ],
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            report($e);
            return response()->json(['status' => false, 'message' => 'Something went wrong'], 500);
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
