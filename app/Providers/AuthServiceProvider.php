<?php

namespace App\Providers;

use App\Models\ClientModel;
use App\Models\EstimateModel;
use App\Models\InvoiceModel;
use App\Models\PaymentModel;
use App\Models\Role;
use App\Models\User;
use App\Policies\ClientPolicy;
use App\Policies\EstimatePolicy;
use App\Policies\InvoicePolicy;
use App\Policies\PaymentPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        InvoiceModel::class => InvoicePolicy::class,
        EstimateModel::class => EstimatePolicy::class,
        ClientModel::class => ClientPolicy::class,
        PaymentModel::class => PaymentPolicy::class,
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
