<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class InvoiceModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'invoices';

    // The primary key associated with the table.
    protected $primaryKey = 'invoice_id';

    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // The attributes that are mass assignable.
    protected $fillable = [
     'user_id',
        'client_id',
        'invoice_number',
        'invoice_date',
        'due_date',
        'status',
        'sub_total',
        'total_tax',
        'total_tax_percent',
        'taxable_value',
    
        'cgst_amount',
        'sgst_amount',
        'igst_amount',
        'total_discount',
        'grand_total',
        'round_off',
        'advance_payment',
        'total_due',
        'notes',
        'terms',
        'currency_code',
        'item_json',
        'upi_id',
        'invoice_code',
        'template_id',
        'is_sent',
        'is_paid',
        'is_overdue',
        'is_cancelled',
        'display_shipping_status',
        'sent_at',
        'paid_at',
        'cancelled_at',
        'overdue_at',
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [];

    // The attributes that should be cast to native types.
    protected $casts = [
        'invoice_date' => 'date',
        'due_date' => 'date',
        'sub_total' => 'decimal:2',
        'total_tax' => 'decimal:2',
        'total_discount' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'advance_payment' => 'decimal:2',
        'total_due' => 'decimal:2',
    ];


    public $sortable = [
        'user_id',
        'client_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'status',
        'sub_total',
        'total_tax',
        'total_discount',
        'grand_total',
        'advance_payment',
        'total_due',
        'notes',
        'terms',
        'currency_code',


    ];
}
