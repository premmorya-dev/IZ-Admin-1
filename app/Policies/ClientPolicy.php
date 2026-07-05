<?php

namespace App\Policies;

use App\Models\ClientModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClientPolicy
{
    use HandlesAuthorization;

    public function view(User $user, ClientModel $client): bool
    {
        return $user->account_id === $client->account_id && $user->hasPermissionTo('view clients');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create clients');
    }

    public function update(User $user, ClientModel $client): bool
    {
        return $user->account_id === $client->account_id && $user->hasPermissionTo('edit clients');
    }

    public function delete(User $user, ClientModel $client): bool
    {
        return $user->account_id === $client->account_id && $user->hasPermissionTo('delete clients');
    }
}
