<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class ExpenseItemModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'expense_items';

    protected $primaryKey = 'expense_item_id';

    public $timestamps = false; // if no created_at / updated_at

    protected $fillable = [
        'user_id',
        'expense_name',
        'expense_item_code',
        'expense_category_id',
        'hsn_sac',
        'item_type',
        'unit_price',
        'status',
        'tax_id',
        'discount_id',
    ];


    public $sortable = [
        'user_id',
        'expense_name',
        'expense_item_code',
        'expense_category_id',
        'hsn_sac',
        'item_type',
        'unit_price',
        'status',
        'tax_id',
        'discount_id',

    ];
}
