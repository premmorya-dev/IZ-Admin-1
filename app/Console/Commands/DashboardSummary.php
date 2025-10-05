<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\InvoiceModel;
use App\Models\NotificationModel;
use App\Models\User;


class DashboardSummary extends Command
{
  protected $signature = 'invoices:dashboard-summary  {--user_id=0}';
  protected $description = 'Refresh User Dashboard';

  public function handle()
  {

    $error = '';
    $log = '';


    $user_id = $this->option('user_id');

    $dashboards = DB::table('dashboard_summary')->select('user_id')
      ->limit(10)
      ->get();



    if ($dashboards->isEmpty()) {
      $log = "\n dashboard queue is empty\n";
      echo $log;
    }


    if (!empty($dashboards)) {

      foreach ($dashboards  as $dashboard) {


        $this->refreshUserDashboard($dashboard);
      }
    }
  }






  public function refreshUserDashboard($dashboard)
  {

    try {



      $data['total_invoice'] = DB::table('invoices')
        ->select(
          'invoices.invoice_id',

        )
        ->where('invoices.user_id', $dashboard->user_id)
        ->get()->count();

      $data['paid_invoices'] = DB::table('invoices')
        ->select(
          'invoices.invoice_id',

        )
        ->where('is_paid', 'Y')
        ->where('invoices.user_id', $dashboard->user_id)
        ->get()->count();


      $data['pending_invoices'] = DB::table('invoices')
        ->select(
          'invoices.invoice_id',

        )
        ->where('is_paid', 'N')
        ->where('invoices.user_id', $dashboard->user_id)
        ->get()->count();


      $invoices =  DB::table('invoices')
        ->select(
          'invoices.*',

        )
        ->where('invoices.user_id', $dashboard->user_id)
        ->get();


      if ($invoices) {
        foreach ($invoices as $key => $invoice) {

          $user = DB::table('users')->where('user_id', $invoice->user_id)->first();
          $data['timezone'] = DB::table('time_zone')->where('time_zone_id', $user->time_zone_id)->first();


          $invoices->due_date = $invoice->due_date;
          // $invoices->due_date =  !empty($invoice->due_date) ? getTimeDateDisplay($user->time_zone_id, $invoice->due_date, 'Y-m-d', 'Y-m-d') : '';
          $today = Carbon::now($data['timezone']->timezone); // user's timezone

          $due_status =  'N';
          if (!empty($invoice->due_date)) {
            $dueDate = Carbon::parse($invoice->due_date);

            if ($dueDate->lt($today)) {
              // Due date is in past
              $due_status =  'Y';
            } elseif ($dueDate->gt($today)) {
              // Due date is in future
              $due_status =  'N';
            } else {
              $due_status =  'N';
            }
          }

          $user = DB::table('invoices')
            ->where('user_id', $invoice->user_id)
            ->where('invoice_id', $invoice->invoice_id)
            ->update([
              'is_overdue' => $due_status,
            ]);
        }
      }



      $data['overdue_invoices'] = DB::table('invoices')
        ->select(
          'invoices.invoice_id',

        )
        ->where('is_overdue', 'Y')
        ->where('invoices.user_id', $dashboard->user_id)
        ->get()->count();


      $data['total_revenue'] = DB::table('invoices')
        ->where('user_id', $dashboard->user_id)
        ->sum('grand_total');

      $data['status_pie_chart'] = json_encode([
        "Paid" =>  $data['paid_invoices'],
        "Overdue" =>  $data['overdue_invoices'],
        "Pending" =>  $data['pending_invoices'],
      ], false);



      $data['recent_invoices'] =  DB::table('invoices')
        ->select(
          'invoices.invoice_number',
          'invoices.invoice_date as date',
          'invoices.status',
          'invoices.grand_total as amount',

        )
        ->where('invoices.user_id', $dashboard->user_id)
        ->limit(5)
        ->get();

      $data['recent_invoices'] = json_encode($data['recent_invoices'], false);




      $data['upcoming_dues'] = DB::table('invoices')
        ->select(
          'invoice_number',
          'due_date',
          'status',
          'grand_total as amount'
        )
        ->where('user_id', $dashboard->user_id)
        ->whereDate('due_date', '>', Carbon::today())
        ->orderBy('due_date', 'asc')
        ->limit(5)
        ->get();


      $data['upcoming_dues'] = json_encode($data['upcoming_dues'], false);


      // Initialize all months with 0
      $months = collect([
        'Jan' => 0,
        'Feb' => 0,
        'Mar' => 0,
        'Apr' => 0,
        'May' => 0,
        'Jun' => 0,
        'Jul' => 0,
        'Aug' => 0,
        'Sep' => 0,
        'Oct' => 0,
        'Nov' => 0,
        'Dec' => 0,
      ]);

      // Get total invoice amounts grouped by month
      $monthlyData = DB::table('invoices')
        ->selectRaw("MONTH(invoice_date) as month, SUM(grand_total) as total")
        ->where('user_id', $dashboard->user_id)
        ->whereYear('invoice_date', Carbon::now()->year)
        ->groupByRaw('MONTH(invoice_date)')
        ->get();

      // Map database month numbers to 3-letter names
      $monthMap = [
        1 => 'Jan',
        2 => 'Feb',
        3 => 'Mar',
        4 => 'Apr',
        5 => 'May',
        6 => 'Jun',
        7 => 'Jul',
        8 => 'Aug',
        9 => 'Sep',
        10 => 'Oct',
        11 => 'Nov',
        12 => 'Dec',
      ];

      // Fill in the actual totals
      foreach ($monthlyData as $row) {
        $monthName = $monthMap[$row->month];
        $months[$monthName] = (float) $row->total;
      }

      // Final JSON for storage
      $data['monthly_invoice_chart'] = $months->toJson();




      $user = DB::table('dashboard_summary')
        ->where('user_id', $dashboard->user_id)
        ->update([
          'total_invoices' => $data['total_invoice'],
          'total_revenue' => $data['total_revenue'],
          'pending_invoices' => $data['pending_invoices'],
          'paid_invoices' => $data['paid_invoices'],
          'overdue_invoices' => $data['overdue_invoices'],
          'monthly_invoice_chart' => $data['monthly_invoice_chart'],
          'status_pie_chart' => $data['status_pie_chart'],
          'recent_invoices' => $data['recent_invoices'],
          'upcoming_dues' => $data['upcoming_dues'],
          'updated_at' => Carbon::now('UTC')->format('Y-m-d H:i:s')


        ]);
    } catch (Exception $e) {
      \Log::channel('info')->error('Error while running dashboard summary cron job: ' . $e->getMessage());
    }
  }
}
