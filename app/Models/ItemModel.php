<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class ItemModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'items';
    protected $primaryKey = 'items_id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'item_name',
        'item_category_id',
        'item_code',
        'sku',
        'hsn_sac',
        'item_type',
        'unit_price',
        'stock',
        'tax_id',
        'status',
        'cost_price',
        'selling_price',
        'discount_id'

    ];

    public $sortable = [
      'user_id',
        'item_name',
        'item_category_id',
        'item_code',
        'sku',
        'hsn_sac',
        'item_type',
        'unit_price',
        'stock',
        'tax_id',
        'status',
        'cost_price',
        'selling_price',
        'discount_id'

    ];
}
