<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class DiscountModel extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'discounts';
    protected $primaryKey = 'discount_id';
    public $timestamps = true; // Because you have created_at and updated_at

    protected $fillable = [
        'user_id',
        'discount_code',
        'name',
        'percent',
        'status',

    ];

    protected $casts = [
        'percent' => 'decimal:2',

    ];
}
