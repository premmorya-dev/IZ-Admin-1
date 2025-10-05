<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

        return view('pages/dashboards.index');
    }

    public function dashboard(Request $request)
    {


        $data = [];
        if (!empty(session('registration')) &&  session('registration') === 'success') {
            $registration_status = 'success';
            session()->forget('registration');
        } else {
            $registration_status = NULL;
        }

        $userId = auth()->id(); // or set a fixed user ID for now

        $summary = \DB::table('dashboard_summary')
            ->where('user_id', $userId)
            ->latest('refreshed_at')
            ->first();



        if (!$summary) {
            // handle empty data

            $data = [
                'summary' => null,
                'monthlyChart' => null,
                'statusChart' => null,
                'recentInvoices' => null,
                'upcomingDues' => null,

            ];

            $data['registration'] =  $registration_status;

            return view('pages/dashboards.dashboard', compact('data'));
        }

        $data = [
            'summary' => $summary,
            'monthlyChart' => json_decode($summary->monthly_invoice_chart, true),
            'statusChart' => json_decode($summary->status_pie_chart, true),
            'recentInvoices' => json_decode($summary->recent_invoices, true),
            'upcomingDues' => json_decode($summary->upcoming_dues, true),
        ];

        $data['registration'] =  $registration_status;


        return view('pages/dashboards.dashboard', compact('data'));
    }
    public function handleCallback(Request $request)
    {


        try {
            $jwt = $request->query('token');

            // Make sure you have JWT_SECRET set in .env and retrieved here
            $secret = config('app.jwt_secret'); // OR better: env('JWT_SECRET');

            // Decode using the new syntax (requires a Key object)
            $payload = JWT::decode($jwt, new Key($secret, 'HS256'));

            // Find and login user


            $user = User::findOrFail($payload->sub);
            Auth::login($user);

            $request->session()->regenerate();

            session(['registration' => 'success']);

            return redirect('/user/login');
        } catch (\Exception $e) {


            return redirect('/login')->with('error', 'Invalid authentication token: ' . $e->getMessage());
        }
    }
}
