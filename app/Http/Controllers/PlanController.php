<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlanModel;
use App\Models\SubscriptionModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class PlanController extends Controller
{




    public function billing(Request $request)
    {

        $activePlan = DB::table('subscriptions')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.plan_id')
            ->where('subscriptions.user_id', auth()->user()->user_id)
            ->where('subscriptions.payment_status', 'paid')
            ->where('subscriptions.ends_at', '>=', now())
            ->orderByDesc('subscriptions.ends_at')
            ->select('subscriptions.*', 'plans.name as plan_name', 'plans.price', 'plans.invoice_limit', 'plans.client_limit', 'plans.duration_days', 'plans.features')
            ->first();

        $userId = auth()->id();

        $payments = DB::table('payments as p')
            ->join('plans as pl', 'p.plan_id', '=', 'pl.plan_id')
            ->join('subscriptions as s', 'p.subscription_id', '=', 's.subscription_id')
            ->select(
                'p.payment_id',
                'p.order_id',
                'p.amount',
                'p.payment_status',
                'p.payment_mode',
                'p.payment_id',
                'p.paid_at',
                'pl.name as plan_name',
                's.starts_at',
                's.ends_at'
            )
            ->where('p.user_id', $userId)
            ->orderByDesc('p.paid_at')
            ->get();

        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();

        foreach ($payments as $key => $invoice) {


            $payments[$key]->paid_at =  !empty($invoice->paid_at) ? getTimeDateDisplay($user->time_zone_id, $invoice->paid_at, 'Y-m-d H:i:s', 'Y-m-d H:i:s') : '';
        }


        return view('pages/plan.billing', compact('activePlan', 'payments'));
    }


    public function planPayment(Request $request, $plan_id)
    {

        $plan = DB::table('plans')->where('plan_id', $plan_id)->first();

        $plan_start =    Carbon::now('UTC')->format('Y-m-d');
        $plan_end =     Carbon::now('UTC')->addDays($plan->duration_days)->format('Y-m-d');
        $user = DB::table('users')->where('user_id', Auth::id())->first();


        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();
        $data['plan_start'] =  !empty($plan_start) ? getTimeDateDisplay($user->time_zone_id, $plan_start, 'd-M-Y', 'Y-m-d') : '';
        $data['plan_end'] =  !empty($plan_end) ? getTimeDateDisplay($user->time_zone_id, $plan_end, 'd-M-Y', 'Y-m-d') : '';

        $paymentKeys = paymentKeys();

        $data['payment_keys'] =  $paymentKeys;

        $api = new Api($paymentKeys['public_key'], $paymentKeys['secret_key']);

        $receiptNumber = 'INVZ-' . date('YmdHis') . '-' . Auth::id(); // or use uniqid()

        $order = $api->order->create([
            'receipt'         => $receiptNumber,
            'amount'          => (int) ($plan->price * 100) * floor($plan->duration_days / 30), // Razorpay expects amount in paisa
            'currency'        => 'INR',
            'payment_capture' => 1
        ]);


        $data['razorpay_order_id'] = $order['id'] ?? '';

        $activePlan = DB::table('subscriptions')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.plan_id')
            ->where('subscriptions.user_id', auth()->user()->user_id)
            ->where('subscriptions.payment_status', 'paid')
            ->where('subscriptions.ends_at', '>=', now())
            ->where('plans.plan_id', $plan_id)
            ->orderByDesc('subscriptions.ends_at')
            ->select('subscriptions.*', 'plans.name as plan_name', 'plans.price', 'plans.invoice_limit', 'plans.client_limit', 'plans.duration_days', 'plans.features')
            ->first();

         


        return view('pages/plan.payment', compact('plan', 'data', 'user' , 'activePlan' ));
    }
    public function upgrade(Request $request)
    {

        $plans = PlanModel::where('is_active', 'Y')->orderBy('price', 'asc')->get();

        $activePlan = DB::table('subscriptions')
            ->join('plans', 'subscriptions.plan_id', '=', 'plans.plan_id')
            ->where('subscriptions.user_id', auth()->user()->user_id)
            ->where('subscriptions.payment_status', 'paid')
            ->where('subscriptions.ends_at', '>=', now())
            ->orderByDesc('subscriptions.ends_at')
            ->select('subscriptions.*', 'plans.name as plan_name', 'plans.price', 'plans.invoice_limit', 'plans.client_limit', 'plans.duration_days', 'plans.features')
            ->first();


        if (empty($activePlan)) {
            return view('pages/plan.plans', compact('plans', 'activePlan'));
        }




        $user = DB::table('users')->where('user_id', Auth::id())->first();
        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();





        $activePlan->starts_at =  !empty($activePlan->starts_at) ? getTimeDateDisplay($user->time_zone_id, $activePlan->starts_at, 'd-M-Y', 'Y-m-d') : '';


        $activePlan->ends_at =  !empty($activePlan->ends_at) ? getTimeDateDisplay($user->time_zone_id, $activePlan->ends_at, 'd-M-Y', 'Y-m-d') : '';


        return view('pages/plan.plans', compact('plans', 'activePlan'));
    }





    public function paymentCallback(Request $request)
    {
        $userId = Auth::id();
        $plan_id = $request->input('plan_id');
        $payment_id = $request->input('razorpay_payment_id');
        $order_id = $request->input('razorpay_order_id');
        $signature = $request->input('razorpay_signature');

        // Fetch selected plan
        $newPlan = DB::table('plans')->where('plan_id', $plan_id)->first();



        try {

            $paymentKeys = paymentKeys();

            $api = new Api($paymentKeys['public_key'], $paymentKeys['secret_key']);

            $payment = $api->payment->fetch($payment_id);


            if (!empty($payment)   &&   $payment['status'] == 'captured') {
                // Expire previous active subscriptions
                DB::table('subscriptions')
                    ->where('user_id', $userId)
                    ->where('payment_status', 'paid')
                    ->whereDate('ends_at', '>=', now())
                    ->update([
                        'payment_status' => 'expired',
                        'cancelled_at' => now(),
                    ]);

                // Create new subscription
                $subscriptionId = DB::table('subscriptions')->insertGetId([
                    'user_id'        => $userId,
                    'plan_id'        => $plan_id,
                    'payment_id'     => $payment_id,
                    'amount_paid'    => $payment['amount'] / 100, // Razorpay stores in paise
                    'currency'       => $payment['currency'],
                    'payment_status' => 'paid',
                    'starts_at'      => now(),
                    'ends_at'        => now()->addDays((int) $newPlan->duration_days),
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);



                // Record payment
                DB::table('payments')->insert([
                    'user_id'         => $userId,
                    'subscription_id' => $subscriptionId,
                    'plan_id'         => $plan_id,
                    'amount'          => $payment['amount'] / 100,
                    'payment_status'  => $payment['status'],
                    'payment_mode'    =>  $payment['method'] ?? 'unknown',
                    'payment_id'      => $payment_id,
                    'signature'       => $signature ?? null,
                    'order_id'        => $order_id ?? $payment->order_id,
                    'paid_at'         => now(),
                    'response'         => json_encode((array)$payment),
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);

                session([
                    'plan_id' => $plan_id,
                    'payment_id' => $payment->id,
                    'amount' => $payment['amount'] / 100, // in paisa
                    'payment_date' => now()
                ]);

                return redirect()->route('payment.success')->with('success', 'Plan upgraded successfully!');
            }
        } catch (\Exception $e) {
            \Log::channel('info')->error('Error while recording payment: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while processing payment.');
        }
    }


    public function paymentSuccess(Request $request)
    {


        if (empty(session('payment_id'))) {
            return abort('404');
        }
        $data = [];
        $plan_id =  session('plan_id');
        $payment_id = session('payment_id');

        session()->forget([
            'plan_id',
            'payment_id'
        ]);




        $plan = DB::table('plans')->where('plan_id', $plan_id)->first();

        $plan_start =    Carbon::now('UTC')->format('Y-m-d');
        $plan_end =     Carbon::now('UTC')->addDays($plan->duration_days)->format('Y-m-d');
        $user = DB::table('users')->where('user_id', Auth::id())->first();


        $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();
        $data['plan_start'] =  !empty($plan_start) ? getTimeDateDisplay($user->time_zone_id, $plan_start, 'd-M-Y', 'Y-m-d') : '';
        $data['plan_end'] =  !empty($plan_end) ? getTimeDateDisplay($user->time_zone_id, $plan_end, 'd-M-Y', 'Y-m-d') : '';



        return view('pages/plan.success', compact('plan', 'data', 'payment_id'));
    }
}
