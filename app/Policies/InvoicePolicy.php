<?php

namespace App\Policies;

use App\Models\InvoiceModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function view(User $user, InvoiceModel $invoice): bool
    {
        return $user->account_id === $invoice->account_id && $user->hasPermissionTo('view invoices');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create invoices');
    }

    public function update(User $user, InvoiceModel $invoice): bool
    {
        return $user->account_id === $invoice->account_id && $user->hasPermissionTo('edit invoices');
    }

    public function delete(User $user, InvoiceModel $invoice): bool
    {
        return $user->account_id === $invoice->account_id && $user->hasPermissionTo('delete invoices');
    }
}
