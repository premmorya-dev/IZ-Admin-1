<?php

namespace App\Models\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Model;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function (Model $model) {
            if (empty($model->account_id) && auth()->check()) {
                $model->account_id = auth()->user()->account_id;
            }
        });
    }

    public function account()
    {
        return $this->belongsTo(\App\Models\Account::class, 'account_id', 'account_id');
    }
}
