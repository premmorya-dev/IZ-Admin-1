<?php

namespace App\Policies;

use App\Models\EstimateModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstimatePolicy
{
    use HandlesAuthorization;

    public function view(User $user, EstimateModel $estimate): bool
    {
        return $user->account_id === $estimate->account_id && $user->hasPermissionTo('view estimates');
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create estimates');
    }

    public function update(User $user, EstimateModel $estimate): bool
    {
        return $user->account_id === $estimate->account_id && $user->hasPermissionTo('edit estimates');
    }

    public function delete(User $user, EstimateModel $estimate): bool
    {
        return $user->account_id === $estimate->account_id && $user->hasPermissionTo('delete estimates');
    }
}
