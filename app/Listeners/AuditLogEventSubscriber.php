<?php

namespace App\Listeners;

use App\Events\RoleAssigned;
use App\Events\RoleCreated;
use App\Events\RoleUpdated;
use App\Events\SubscriptionUpgraded;
use App\Events\UserCreated;
use App\Events\UserDeleted;
use App\Models\AuditLog;

class AuditLogEventSubscriber
{
    public function handleUserCreated(UserCreated $event): void
    {
        AuditLog::create([
            'account_id' => $event->user->account_id,
            'user_id' => $event->actor->user_id,
            'action' => 'user.created',
            'model_type' => get_class($event->user),
            'model_id' => $event->user->user_id,
            'ip_address' => request()->ip(),
            'meta' => ['email' => $event->user->email],
        ]);
    }

    public function handleUserDeleted(UserDeleted $event): void
    {
        AuditLog::create([
            'account_id' => $event->user->account_id,
            'user_id' => $event->actor->user_id,
            'action' => 'user.deleted',
            'model_type' => get_class($event->user),
            'model_id' => $event->user->user_id,
            'ip_address' => request()->ip(),
            'meta' => ['email' => $event->user->email],
        ]);
    }

    public function handleRoleCreated(RoleCreated $event): void
    {
        AuditLog::create([
            'account_id' => $event->role->account_id,
            'user_id' => $event->actor->user_id,
            'action' => 'role.created',
            'model_type' => get_class($event->role),
            'model_id' => $event->role->id,
            'ip_address' => request()->ip(),
            'meta' => ['name' => $event->role->name],
        ]);
    }

    public function handleRoleUpdated(RoleUpdated $event): void
    {
        AuditLog::create([
            'account_id' => $event->role->account_id,
            'user_id' => $event->actor->user_id,
            'action' => 'role.updated',
            'model_type' => get_class($event->role),
            'model_id' => $event->role->id,
            'ip_address' => request()->ip(),
            'meta' => ['name' => $event->role->name],
        ]);
    }

    public function handleRoleAssigned(RoleAssigned $event): void
    {
        AuditLog::create([
            'account_id' => $event->assignee->account_id,
            'user_id' => $event->actor->user_id,
            'action' => 'role.assigned',
            'model_type' => get_class($event->role),
            'model_id' => $event->role->id,
            'ip_address' => request()->ip(),
            'meta' => ['assignee_id' => $event->assignee->user_id, 'role_name' => $event->role->name],
        ]);
    }

    public function handleSubscriptionUpgraded(SubscriptionUpgraded $event): void
    {
        AuditLog::create([
            'account_id' => $event->subscription->account_id,
            'user_id' => $event->actor->user_id,
            'action' => 'subscription.upgraded',
            'model_type' => get_class($event->subscription),
            'model_id' => $event->subscription->subscription_id,
            'ip_address' => request()->ip(),
            'meta' => ['plan_id' => $event->subscription->plan_id],
        ]);
    }

    public function subscribe($events): void
    {
        $events->listen(UserCreated::class, [AuditLogEventSubscriber::class, 'handleUserCreated']);
        $events->listen(UserDeleted::class, [AuditLogEventSubscriber::class, 'handleUserDeleted']);
        $events->listen(RoleCreated::class, [AuditLogEventSubscriber::class, 'handleRoleCreated']);
        $events->listen(RoleUpdated::class, [AuditLogEventSubscriber::class, 'handleRoleUpdated']);
        $events->listen(RoleAssigned::class, [AuditLogEventSubscriber::class, 'handleRoleAssigned']);
        $events->listen(SubscriptionUpgraded::class, [AuditLogEventSubscriber::class, 'handleSubscriptionUpgraded']);
    }
}
