<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use App\Jobs\SendProductionErrorMailJob;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;



class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {


            $errorHash = md5(
                $e->getMessage() .
                    $e->getFile() .
                    $e->getLine()
            );

            $data = [

                'error_hash' => $errorHash,

                'message' => $e->getMessage(),

                'file' => $e->getFile(),

                'line' => $e->getLine(),

                'trace' => $e->getTraceAsString(),

                'url' => request()->fullUrl(),

                'method' => request()->method(),

                'request_data' => request()->except([
                    '_token',
                    'password',
                    'password_confirmation'
                ]),

                'user_id' => auth()->id(),

                'user_name' => optional(auth()->user())->name,

                'user_email' => optional(auth()->user())->email,

                'ip_address' => request()->ip(),

                'user_agent' => request()->userAgent(),

                'server_name' => gethostname(),

                'environment' => app()->environment(),

                'laravel_version' => app()->version(),

                'php_version' => PHP_VERSION,

                'error_count' => 1,

                'first_seen_at' => now(),

                'last_seen_at' => now(),

                'time' => now()->toDateTimeString()

            ];


            $exists = DB::table('production_errors')
                ->where('error_hash', $errorHash)
                ->first();

            if ($exists) {

                DB::table('production_errors')
                    ->where('id', $exists->id)
                    ->update([

                        'error_count' => DB::raw('error_count+1'),

                        'last_seen_at' => now(),

                        'updated_at' => now()

                    ]);
            } else {

                DB::table('production_errors')->insert([

                    'error_hash' => $data['error_hash'],

                    'message' => $data['message'],

                    'file' => $data['file'],

                    'line' => $data['line'],

                    'trace' => $data['trace'],

                    'url' => $data['url'],

                    'method' => $data['method'],

                    'request_data' => json_encode($data['request_data']),

                    'user_id' => $data['user_id'],

                    'user_name' => $data['user_name'],

                    'user_email' => $data['user_email'],

                    'ip_address' => $data['ip_address'],

                    'user_agent' => $data['user_agent'],

                    'server_name' => $data['server_name'],

                    'environment' => $data['environment'],

                    'laravel_version' => $data['laravel_version'],

                    'php_version' => $data['php_version'],

                    'error_count' => 1,

                    'first_seen_at' => now(),

                    'last_seen_at' => now(),

                    'created_at' => now(),

                    'updated_at' => now()

                ]);
            }

            if (!app()->environment('production')) {
                return;
            }

            if (Cache::has($errorHash)) {
                return;
            }

            Cache::put($errorHash, true, now()->addMinutes(30));

            SendProductionErrorMailJob::dispatch($data);
        });
    }
}
