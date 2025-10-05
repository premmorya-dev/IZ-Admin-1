<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


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
        'plan_id',
        'payment_id',
        'amount_paid',
        'currency',
        'payment_status',
        'starts_at',
        'ends_at',
        'cancelled_at',
    ];

  
}
