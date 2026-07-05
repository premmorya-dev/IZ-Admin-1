<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $actor;
    public User $user;

    public function __construct(User $actor, User $user)
    {
        $this->actor = $actor;
        $this->user = $user;
    }
}
