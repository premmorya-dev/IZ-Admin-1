<?php

namespace App\Providers;

use App\Core\KTBootstrap;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {




        // DB::listen(function ($query) {
        //     Log::info("SQL: {$query->sql}");
        //     Log::info("Bindings: " . json_encode($query->bindings));
        //     Log::info("Time: {$query->time}");
        // });

        // DB::listen(function ($query) {
        //     if ($query->time > 200) { // only log slow queries >200ms
        //         $trace = collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))
        //             ->pluck('file', 'line')
        //             ->filter()
        //             ->take(10); // limit stack trace to 10 frames

        //         Log::info("SQL: {$query->sql}");
        //         Log::info("Bindings: " . json_encode($query->bindings));
        //         Log::info("Time: {$query->time} ms");
        //         Log::info("Trace: " . json_encode($trace));
        //     }
        // });

        // DB::listen(function ($query) {
        //     if ($query->sql === "select * from `invoicezy_settings` where `invoicezy_settings`.`setting_id` is null limit 1") {
        //         throw new \Exception("Who is calling invoicezy_settings with null?");
        //     }
        // });


        // Update defaultStringLength
        Builder::defaultStringLength(191);

        KTBootstrap::init();
    }
}
