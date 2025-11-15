<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillModel extends Model
{
    use HasFactory;

    protected $table = 'bills';
    protected $primaryKey = 'bill_id';

    protected $fillable = [
        'user_id',
        'vendor_id',
        'bill_number',
        'bill_code',
        'order_number',
        'bill_date',
        'due_date',
        'bill_status',
        'sub_total',
        'total_tax',
        'total_discount',
        'grand_total',
        'round_off',
        'total_due',
        'item_json',
        'currency_code',
        'payment_mode',
        'bill_file_path',
        'notes',
        'terms',
        'supply_source_state_id',
        'template_id',
        'destination_source_state_id',
        'bill_month',
        'bill_financial_year',
        'is_recurring',
        'is_gst_compliant',
        'is_paid',
        'paid_at',
    ];

    protected $casts = [
        'bill_date' => 'date',
        'due_date' => 'date',
        'item_json' => 'array',
        'paid_at' => 'datetime',
        'sub_total' => 'decimal:2',
        'total_tax' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'round_off' => 'decimal:2',
        'total_due' => 'decimal:2',
    ];

}
