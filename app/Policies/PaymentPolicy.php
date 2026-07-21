<?php

namespace App\Policies;

use App\Models\PaymentModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;

    public function view(User $user, PaymentModel $payment): bool
    {
        return $user->account_id === $payment->account_id && $user->hasPermissionTo('view payments');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create payments');
    }

    public function update(User $user, PaymentModel $payment): bool
    {
        return $user->account_id === $payment->account_id && $user->hasPermissionTo('edit payments');
    }

    public function delete(User $user, PaymentModel $payment): bool
    {
        return $user->account_id === $payment->account_id && $user->hasPermissionTo('delete payments');
    }
}
