<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $actor, User $user): bool
    {
        return $actor->account_id === $user->account_id && $actor->hasPermissionTo('view users');
    }

    public function create(User $actor): bool
    {
        return $actor->hasPermissionTo('create users');
    }

    public function update(User $actor, User $user): bool
    {
        return $actor->account_id === $user->account_id && $actor->hasPermissionTo('edit users');
    }

    public function delete(User $actor, User $user): bool
    {
        return $actor->account_id === $user->account_id && $actor->hasPermissionTo('delete users');
    }
}
