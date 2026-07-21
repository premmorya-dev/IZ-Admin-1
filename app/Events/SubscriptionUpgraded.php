<?php

namespace App\Events;

use App\Models\SubscriptionModel;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionUpgraded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $actor;
    public SubscriptionModel $subscription;

    public function __construct(User $actor, SubscriptionModel $subscription)
    {
        $this->actor = $actor;
        $this->subscription = $subscription;
    }
}
