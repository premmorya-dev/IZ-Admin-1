<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class ExpenseModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'expenses';

    // Primary key
    protected $primaryKey = 'expense_id';

    // Mass assignable fields
    protected $fillable = [
        'expense_code',
        'expense_number',
        'expense_image',
        'item_json',
        'user_id',
        'vendor_id',
        'expense_category',
        'expense_notes',
        'original_invoice_number',
        'expense_date',
        'payment_mode',
        'amount',
        'is_gst',
        'is_paid',
        'gst_amount',
        'template_id',
        'currency_code',
        'non_gst_amount',
        'notes'
    ];
    public $sortable = [
        'expense_code',
        'expense_number',
        'expense_image',
        'item_json',
        'user_id',
        'vendor_id',
        'expense_category',
        'expense_notes',
        'original_invoice_number',
        'expense_date',
        'payment_mode',
        'amount',
        'is_gst',
        'is_paid',
        'gst_amount',
        'template_id',
        'currency_code',
        'non_gst_amount',
        'notes'
    ];
}
