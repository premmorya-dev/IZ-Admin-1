<?php

namespace App\Services;

use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Hashing\HashManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class UserManagementService
{
    protected HashManager $hash;
    protected Dispatcher $events;

    public function __construct(HashManager $hash, Dispatcher $events)
    {
        $this->hash = $hash;
        $this->events = $events;
    }

    public function createUser(array $data, Authenticatable $creator): User
    {
        $accountId = $creator->account_id;
        $this->assertUserLimit($creator);

        $payload = Arr::only($data, [
            'name',
            'email',
            'password',
            'profile_photo_path',
            'status',
            'user_type',
        ]);

        $payload['account_id'] = $accountId;
        $payload['password'] = $this->hash->make($data['password'] ?? $data['email']);

        $user = User::create($payload);

        if (!empty($data['role'])) {
            $user->assignRole($data['role']);
        }

        Password::sendResetLink($user->only('email'));

        $this->events->dispatch(new UserCreated($creator, $user));

        return $user;
    }

    public function deleteUser(User $user, Authenticatable $actor): bool
    {
        if ($user->user_id === $actor->user_id) {
            throw ValidationException::withMessages(['user' => 'Unable to delete current signed-in user.']);
        }

        if ($user->account_id !== $actor->account_id) {
            throw ValidationException::withMessages(['user' => 'Unauthorized action.']);
        }

        $result = $user->delete();
        $this->events->dispatch(new UserDeleted($actor, $user));

        return $result;
    }

    public function assertUserLimit(Authenticatable $creator): void
    {
        $activeSubscription = $creator->account->activeSubscription;

        if (! $activeSubscription) {
            return;
        }

        $plan = $activeSubscription->plan;

        if ($plan && $plan->user_limit !== null && $plan->user_limit >= 0) {
            $currentUsers = User::where('account_id', $creator->account_id)->count();

            if ($currentUsers >= $plan->user_limit) {
                throw ValidationException::withMessages([
                    'user_limit' => 'You have reached your plan\'s maximum user limit. Please upgrade your plan.',
                ]);
            }
        }
    }
}
