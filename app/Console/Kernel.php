<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\CommandCronWatcher\CronWatcher;







class Kernel extends ConsoleKernel
{

    protected $commands = [

        CronWatcher::class,

    ];


    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('invoices:send-emails')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/cron_send_email.log'));

        $schedule->command('send-estimate-email')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/send_estimate_email.log'));

        $schedule->command('invoices:dashboard-summary')
            ->everyTenMinutes()
            ->appendOutputTo(storage_path('logs/cron_dashboard_summary.log'));

        $schedule->command('app:send-invoice-reminders-before-due-date')
            ->dailyAt('10:00')
            ->appendOutputTo(storage_path('logs/send_invoice_reminders_before_due_date.log'));

        $schedule->command('app:send-invoice-reminders-after-due-date')
            ->dailyAt('11:00')
            ->appendOutputTo(storage_path('logs/send_invoice_reminders_after_due_date.log'));
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        // $this->load(__DIR__ . '/CommandCronWatcher');

        require base_path('routes/console.php');
    }
}
