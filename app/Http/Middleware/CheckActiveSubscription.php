<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CheckActiveSubscription
{
    public function handle(Request $request, Closure $next)
    {


        $user = Auth::user();

        $msg = '';

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in.');
        }

        $activeSubscription = DB::table('subscriptions')
            ->where('user_id', $user->user_id)
            ->where('payment_status', 'paid')
            ->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>=', Carbon::now())
            ->first();



        if (!isset($activeSubscription->plan_id) ||  empty($activeSubscription->plan_id)) {
            $plan_id = 1;
        } else {
            $plan_id =  $activeSubscription->plan_id;
        }

        // Get the plan details for the active subscription
        $plan = DB::table('plans')->where('plan_id', $plan_id)->first();

        if (!$plan) {


            $msg = 'Your subscription plan is no longer available.';
            session()->flash('msg', $msg);

            if ($request->ajax()) {
                return response()->json([
                    'error' => 1,
                    'redirect' => route('subscription.error.page'),
                    'message' => $msg
                ], 403);
            }
            return redirect()->route('subscription.error.page');
        }

        // Decode the features from JSON and check if a specific feature is required
        $features = json_decode($plan->features, true);


        $routeName = $request->route()->getName();

        if (str_starts_with($routeName, 'invoice')  && $plan_id != 4  ) {
            if (isset($plan->invoice_limit) && $plan->invoice_limit < $this->getUserInvoiceCount($user)) {

                $msg = 'You have exceeded your invoice limit. Please upgrade your plan.';
                session()->flash('msg', $msg);

                if ($request->ajax()) {
                    return response()->json([
                        'error' => 1,
                        'redirect' => route('subscription.error.page'),
                        'message' => $msg
                    ], 403);
                }
                return redirect()->route('subscription.error.page');
            }
        }
        // Example: Check if the user exceeds their allowed invoice limit

        if (str_starts_with($routeName, 'client') && $plan_id != 4  ) {

            if (isset($plan->client_limit) && $plan->client_limit < $this->getUserClientCount($user)) {
                $msg = 'You have exceeded your client limit. Please upgrade your plan.';
                session()->flash('msg', $msg);

                if ($request->ajax()) {
                    return response()->json([
                        'error' => 1,
                        'redirect' => route('subscription.error.page'),
                        'message' => $msg
                    ], 403);
                }
                return redirect()->route('subscription.error.page');
            }
        }
        // Add more checks for other features as needed, e.g., client limits or other features

        return $next($request);
    }

    // Helper method to get the user's current invoice count
    private function getUserInvoiceCount($user)
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString(); // e.g., 2025-06-01
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();     // e.g., 2025-06-30

        return DB::table('invoices')
            ->where('user_id', $user->user_id)
            ->whereBetween('invoice_date', [$startOfMonth, $endOfMonth])
            ->count();
    }

    private function getUserClientCount($user)
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateTimeString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateTimeString();

        return DB::table('clients')
            ->where('user_id', $user->user_id)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();
    }
}
