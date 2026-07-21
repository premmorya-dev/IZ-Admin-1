<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Models\Account;
use App\Models\PlanModel;

class SubscriptionModel extends Model
{
    use HasFactory;
    use Sortable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'subscriptions';
    protected $primaryKey = 'subscription_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'account_id',
        'plan_id',
        'payment_id',
        'amount_paid',
        'currency',
        'payment_status',
        'starts_at',
        'ends_at',
        'cancelled_at',
    ];

   
    public $sortable = [
        'user_id',
        'account_id',
        'plan_id',
        'payment_id',
        'amount_paid',
        'currency',
        'payment_status',
        'starts_at',
        'ends_at',
        'cancelled_at',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'account_id');
    }

    public function plan()
    {
        return $this->belongsTo(PlanModel::class, 'plan_id', 'plan_id');
    }

    public function scopeActive($query)
    {
        return $query->where('payment_status', 'paid')
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now());
    }
}
