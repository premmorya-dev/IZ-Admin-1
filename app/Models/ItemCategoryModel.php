<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class ItemCategoryModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'item_categories';
    protected $primaryKey = 'item_category_id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'item_category_id',
        'user_id',
        'category_name',


    ];

    public $sortable = [
        'item_category_id',
        'user_id',
        'category_name',


    ];
}
