<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $primaryKey = 'account_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'owner_id',
        'status',
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'account_id', 'account_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id', 'user_id');
    }

    public function subscriptions()
    {
        return $this->hasMany(SubscriptionModel::class, 'account_id', 'account_id');
    }

    public function activeSubscription()
    {
        return $this->hasOne(SubscriptionModel::class, 'account_id', 'account_id')
            ->where('payment_status', 'paid')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }
}
