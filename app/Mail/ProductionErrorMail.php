<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Throwable;

class ProductionErrorMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(Throwable $exception)
    {
        $this->data = [
            'message'     => $exception->getMessage(),
            'file'        => $exception->getFile(),
            'line'        => $exception->getLine(),
            'trace'       => $exception->getTraceAsString(),

            'url'         => request()->fullUrl(),
            'method'      => request()->method(),
            'ip'          => request()->ip(),
            'user_agent'  => request()->userAgent(),

            'user'        => auth()->check()
                                ? auth()->user()->only(['id','name','email'])
                                : null,

            'input'       => request()->except([
                                'password',
                                'password_confirmation',
                                '_token'
                            ]),

            'server'      => gethostname(),
            'environment' => app()->environment(),
            'php_version' => PHP_VERSION,
            'laravel'     => app()->version(),
            'time'        => now()->toDateTimeString(),
        ];
    }

    public function build()
    {
        return $this->subject('🚨 Invoicezy Production Error')
            ->view('emails.production-error')
            ->with([
                'data' => $this->data
            ]);
    }
}