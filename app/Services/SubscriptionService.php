<?php

namespace App\Services;

use App\Models\Account;
use App\Models\SubscriptionModel;
use Carbon\Carbon;

class SubscriptionService
{
    public function activeForAccount(Account $account): ?SubscriptionModel
    {
        return $account->subscriptions()
            ->where('payment_status', 'paid')
            ->where('starts_at', '<=', Carbon::now())
            ->where('ends_at', '>=', Carbon::now())
            ->latest('ends_at')
            ->first();
    }
}
