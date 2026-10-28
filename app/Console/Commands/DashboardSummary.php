<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class DashboardSummary extends Command
{
    protected $signature = 'invoices:dashboard-summary
                            {--user_id=0 : Sirf is user ka dashboard refresh karo}
                            {--chunk=200 : Ek baar me kitne users process karne hain}';

    protected $description = 'Refresh User Dashboard';

    private const MONTHS = [
        1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun',
        7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec',
    ];

    public function handle(): int
    {
        DB::disableQueryLog(); // long-running command me memory na bhare

        $started   = microtime(true);
        $onlyUser  = (int) $this->option('user_id');
        $chunkSize = max(1, (int) $this->option('chunk'));

        $userIds = DB::table('dashboard_summary')
            ->when($onlyUser > 0, fn ($q) => $q->where('user_id', $onlyUser))
            ->distinct()
            ->pluck('user_id')
            ->all();

        if (empty($userIds)) {
            $this->info('Dashboard queue is empty');
            return self::SUCCESS;
        }

        // 1) Overdue: har invoice ke liye alag query ki jagah, timezone ke hisaab se bulk update
        $overdueMarked = $this->markOverdueInvoices($onlyUser);

        // 2) Users ko chunks me process karo
        $ok = 0;
        $failed = 0;

        foreach (array_chunk($userIds, $chunkSize) as $ids) {
            try {
                [$o, $f] = $this->refreshChunk($ids);
                $ok += $o;
                $failed += $f;
            } catch (Throwable $e) {
                $failed += count($ids);
                Log::channel('info')->error('Dashboard summary chunk failed: ' . $e->getMessage());
            }
        }

        $this->info(sprintf(
            'Dashboard refreshed: %d ok, %d failed, %d invoices marked overdue, %.2fs',
            $ok, $failed, $overdueMarked, microtime(true) - $started
        ));

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    /**
     * Pending + due date nikal chuki invoices ko overdue karo.
     * "Aaj" ki date user ke timezone se nikalti hai, par query sirf timezone ke hisaab se
     * (kam hoti hain) chalti hai, invoice ke hisaab se nahi.
     */
    private function markOverdueInvoices(int $onlyUser): int
    {
        $zones = DB::table('users')
            ->join('dashboard_summary', 'dashboard_summary.user_id', '=', 'users.user_id')
            ->leftJoin('time_zone', 'time_zone.time_zone_id', '=', 'users.time_zone_id')
            ->when($onlyUser > 0, fn ($q) => $q->where('users.user_id', $onlyUser))
            ->select('users.time_zone_id', 'time_zone.timezone')
            ->distinct()
            ->get();

        $affected = 0;

        foreach ($zones as $zone) {
            try {
                $today = Carbon::now($zone->timezone ?: config('app.timezone'))->toDateString();
            } catch (Throwable $e) {
                $today = Carbon::now()->toDateString();
            }

            $affected += DB::table('invoices')
                ->where('status', 'pending')
                ->where('total_due', '>', 0)
                ->whereNotNull('due_date')
                ->where('due_date', '<', $today)
                ->whereIn('user_id', function ($q) use ($zone, $onlyUser) {
                    $q->select('users.user_id')
                        ->from('users')
                        ->join('dashboard_summary', 'dashboard_summary.user_id', '=', 'users.user_id')
                        ->when(
                            $zone->time_zone_id === null,
                            fn ($q2) => $q2->whereNull('users.time_zone_id'),
                            fn ($q2) => $q2->where('users.time_zone_id', $zone->time_zone_id)
                        )
                        ->when($onlyUser > 0, fn ($q2) => $q2->where('users.user_id', $onlyUser));
                })
                ->update([
                    'status'     => 'overdue',
                    'overdue_at' => now(),
                ]);
        }

        return $affected;
    }

    /**
     * Ek chunk ke saare users: counts + revenue + monthly chart ek-ek query me,
     * fir har user ke recent/upcoming (limit 5) aur ek transaction me write.
     */
    private function refreshChunk(array $ids): array
    {
        // Counts + revenue: poore chunk ke liye ek query
        $totals = DB::table('invoices')
            ->selectRaw("
                user_id,
                COUNT(*) AS total_invoices,
                SUM(status = 'paid')    AS paid_invoices,
                SUM(status = 'pending') AS pending_invoices,
                SUM(status = 'overdue') AS overdue_invoices,
                COALESCE(SUM(CASE WHEN status = 'paid' THEN grand_total ELSE 0 END), 0) AS total_revenue
            ")
            ->whereIn('user_id', $ids)
            ->groupBy('user_id')
            ->get()
            ->keyBy('user_id');

        // Monthly chart: poore chunk ke liye ek query (range filter => index use hota hai)
        $year = Carbon::now()->year;

        $monthlyRows = DB::table('invoices')
            ->selectRaw('user_id, MONTH(invoice_date) AS m, SUM(grand_total) AS total')
            ->whereIn('user_id', $ids)
            ->where('invoice_date', '>=', "{$year}-01-01")
            ->where('invoice_date', '<', ($year + 1) . '-01-01')
            ->groupBy('user_id')
            ->groupByRaw('MONTH(invoice_date)')
            ->get();

        $monthlyByUser = [];
        foreach ($monthlyRows as $row) {
            $monthlyByUser[$row->user_id][(int) $row->m] = (float) $row->total;
        }

        $tomorrow = Carbon::tomorrow()->toDateString();
        $now      = Carbon::now('UTC')->format('Y-m-d H:i:s');

        return DB::transaction(function () use ($ids, $totals, $monthlyByUser, $tomorrow, $now) {
            $ok = 0;
            $failed = 0;

            foreach ($ids as $uid) {
                try {
                    $t = $totals->get($uid);

                    $paid    = (int) ($t->paid_invoices ?? 0);
                    $pending = (int) ($t->pending_invoices ?? 0);
                    $overdue = (int) ($t->overdue_invoices ?? 0);

                    $months = array_fill_keys(array_values(self::MONTHS), 0);
                    foreach ($monthlyByUser[$uid] ?? [] as $m => $total) {
                        $months[self::MONTHS[$m]] = $total;
                    }

                    // Latest 5 (composite index: user_id + invoice_date)
                    $recent = DB::table('invoices')
                        ->select('invoice_number', 'invoice_date as date', 'status', 'grand_total as amount')
                        ->where('user_id', $uid)
                        ->orderByDesc('invoice_date')
                        ->orderByDesc('invoice_id')
                        ->limit(5)
                        ->get();

                    // Next 5 due (composite index: user_id + due_date)
                    $upcoming = DB::table('invoices')
                        ->select('invoice_number', 'due_date', 'status', 'grand_total as amount')
                        ->where('user_id', $uid)
                        ->where('due_date', '>=', $tomorrow)
                        ->whereNotIn('status', ['paid', 'cancelled'])
                        ->orderBy('due_date')
                        ->limit(5)
                        ->get();

                    DB::table('dashboard_summary')
                        ->where('user_id', $uid)
                        ->update([
                            'total_invoices'        => (int) ($t->total_invoices ?? 0),
                            'total_revenue'         => (float) ($t->total_revenue ?? 0),
                            'pending_invoices'      => $pending,
                            'paid_invoices'         => $paid,
                            'overdue_invoices'      => $overdue,
                            'monthly_invoice_chart' => json_encode($months),
                            'status_pie_chart'      => json_encode([
                                'Paid'    => $paid,
                                'Overdue' => $overdue,
                                'Pending' => $pending,
                            ]),
                            'recent_invoices'       => json_encode($recent),
                            'upcoming_dues'         => json_encode($upcoming),
                            'updated_at'            => $now,
                        ]);

                    $ok++;
                } catch (Throwable $e) {
                    $failed++;
                    Log::channel('info')->error("Dashboard summary failed for user {$uid}: " . $e->getMessage());
                }
            }

            return [$ok, $failed];
        });
    }
}