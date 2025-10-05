<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class ExpenseCategoryModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'expense_categories';
    protected $primaryKey = 'expense_category_id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'expense_category_id',
        'user_id',
        'category_name',
        'expense_category_code',


    ];

    public $sortable = [
        'expense_category_id',
        'user_id',
        'category_name',
        'expense_category_code',


    ];
}
