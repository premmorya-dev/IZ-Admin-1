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

            $request = request();
            $user = auth()->user();

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

                'url' => $request ? $request->fullUrl() : null,
                'method' => $request ? $request->method() : null,
                'request_data' => $request ? $request->except([
                    '_token',
                    'password',
                    'password_confirmation'
                ]) : null,

                'user_id' => $user?->id,
                'user_name' => $user?->name,
                'user_email' => $user?->email,

                'ip_address' => $request ? $request->ip() : null,
                'user_agent' => $request ? $request->userAgent() : null,

                'server_name' => gethostname() ?: null,
                'environment' => app()->environment(),
                'laravel_version' => app()->version(),
                'php_version' => PHP_VERSION,

                'error_count' => 1,
                'first_seen_at' => now(),
                'last_seen_at' => now(),
                'time' => now()->toDateTimeString(),
            ];

            $exists = DB::table('production_errors')
                ->where('error_hash', $errorHash)
                ->first();

            if ($exists) {

                DB::table('production_errors')
                    ->where('id', $exists->id)
                    ->update([
                        'error_count' => DB::raw('error_count + 1'),
                        'last_seen_at' => now(),
                        'updated_at' => now(),
                    ]);
            } else {

                DB::table('production_errors')->insert([
                    'error_hash' => data_get($data, 'error_hash'),
                    'message' => data_get($data, 'message'),
                    'file' => data_get($data, 'file'),
                    'line' => data_get($data, 'line'),
                    'trace' => data_get($data, 'trace'),
                    'url' => data_get($data, 'url'),
                    'method' => data_get($data, 'method'),
                    'request_data' => data_get($data, 'request_data')
                        ? json_encode(data_get($data, 'request_data'))
                        : null,
                    'user_id' => data_get($data, 'user_id'),
                    'user_name' => data_get($data, 'user_name'),
                    'user_email' => data_get($data, 'user_email'),
                    'ip_address' => data_get($data, 'ip_address'),
                    'user_agent' => data_get($data, 'user_agent'),
                    'server_name' => data_get($data, 'server_name'),
                    'environment' => data_get($data, 'environment'),
                    'laravel_version' => data_get($data, 'laravel_version'),
                    'php_version' => data_get($data, 'php_version'),
                    'error_count' => data_get($data, 'error_count', 1),
                    'first_seen_at' => data_get($data, 'first_seen_at'),
                    'last_seen_at' => data_get($data, 'last_seen_at'),
                    'created_at' => now(),
                    'updated_at' => now(),
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
