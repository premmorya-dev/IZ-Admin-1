<?php

namespace App\Jobs;

use App\Enums\EmailType;
use App\Models\EmailSequence;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendOnboardingEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $timeout = 60;
    public array $backoff = [30, 120, 300];

    public function __construct(
        public int $userId,
        public EmailType $type,
    ) {
        $this->onQueue('emails');
    }

    /**
     * Entry point: schedule the full onboarding sequence for a newly
     * registered user. Call this from the registration flow only.
     */
    public static function scheduleFor(User $user): void
    {
        foreach (EmailType::cases() as $type) {
            DB::transaction(function () use ($user, $type) {
                $sequence = EmailSequence::firstOrCreate(
                    ['user_id' => $user->user_id, 'type' => $type->value],
                    [
                        'status'       => EmailSequence::STATUS_PENDING,
                        'scheduled_at' => now()->addMinutes($type->delayInMinutes()),
                    ]
                );

                // Only dispatch if this is a fresh record (prevents duplicate
                // dispatch if registration logic runs twice for the same user).
                if ($sequence->wasRecentlyCreated) {
                    self::dispatch($user->user_id, $type)
                        ->delay(now()->addMinutes($type->delayInMinutes()));
                }
            });
        }
    }

    public function handle(EmailService $emailService): void
    {
        $sequence = EmailSequence::where('user_id', $this->userId)
            ->ofType($this->type)
            ->first();

        // No record, or already handled -> nothing to do (idempotent).
        if (! $sequence || $sequence->status !== EmailSequence::STATUS_PENDING) {
            return;
        }

        $user = User::find($this->userId);

        if (! $user) {
            $sequence->update([
                'status' => EmailSequence::STATUS_SKIPPED,
                'error'  => 'User no longer exists',
            ]);

            return;
        }

        if ($this->shouldSkip($user)) {
            $sequence->update(['status' => EmailSequence::STATUS_SKIPPED]);

            return;
        }

        $emailService->send(
            to: $user->email,
            toName: $user->first_name . ' ' . $user->last_name,
            subject: $this->type->subject(),
            view: $this->type->view(),
            data: ['user' => $user],
        );

        $sequence->update([
            'status'  => EmailSequence::STATUS_SENT,
            'sent_at' => now(),
        ]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error('SendOnboardingEmailJob failed', [
            'user_id' => $this->userId,
            'type'    => $this->type->value,
            'error'   => $exception->getMessage(),
        ]);

        EmailSequence::where('user_id', $this->userId)
            ->ofType($this->type)
            ->update([
                'status' => EmailSequence::STATUS_FAILED,
                'error'  => $exception->getMessage(),
            ]);
    }

    /**
     * Business rules that determine whether an onboarding email should
     * be skipped even though its scheduled time has arrived.
     */
    protected function shouldSkip(User $user): bool
    {
        return match ($this->type) {
            EmailType::FirstInvoice => method_exists($user, 'invoices')
                && $user->invoices()->exists(),

            EmailType::PremiumUpgrade,
            EmailType::AnnualDiscount => method_exists($user, 'hasPremiumPlan')
                && $user->hasPremiumPlan(),

            default => false,
        };
    }
}
