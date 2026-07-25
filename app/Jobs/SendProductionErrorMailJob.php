<?php

namespace App\Jobs;

use App\Services\ErrorMailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendProductionErrorMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(ErrorMailService $mailService)
    {
        $body = view('emails.production-error', [
            'data' => $this->data
        ])->render();

        $mailService->send(
            'Invoicezy Production Error',
            $body
        );
    }
}