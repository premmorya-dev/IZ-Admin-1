<?php

namespace App\Events;

use App\Models\Role;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $actor;
    public Role $role;

    public function __construct(User $actor, Role $role)
    {
        $this->actor = $actor;
        $this->role = $role;
    }
}
