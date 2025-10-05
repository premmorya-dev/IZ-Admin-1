<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class PaymentModel extends Model
{
    use HasFactory;
    use Sortable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'invoice_payments';

    protected $primaryKey = 'invoice_payment_id';
    public $timestamps = true;
    protected $fillable = [
        'invoice_id',
        'user_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];
   
    public $sortable = [
        'invoice_id',
        'user_id',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'notes',
    ];

  
}
