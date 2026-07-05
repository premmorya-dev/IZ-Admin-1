<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function view(User $actor, Role $role): bool
    {
        return $actor->account_id === $role->account_id && $actor->hasPermissionTo('view roles');
    }

    public function create(User $actor): bool
    {
        return $actor->hasPermissionTo('create roles');
    }

    public function update(User $actor, Role $role): bool
    {
        return $actor->account_id === $role->account_id && $actor->hasPermissionTo('edit roles');
    }

    public function delete(User $actor, Role $role): bool
    {
        return $actor->account_id === $role->account_id && $actor->hasPermissionTo('delete roles');
    }
}
