<?php

namespace App\Events;

use App\Models\Role;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RoleAssigned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $actor;
    public User $assignee;
    public Role $role;

    public function __construct(User $actor, User $assignee, Role $role)
    {
        $this->actor = $actor;
        $this->assignee = $assignee;
        $this->role = $role;
    }
}
