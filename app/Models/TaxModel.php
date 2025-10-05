<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class TaxModel extends Model
{
    use HasFactory;
    use Sortable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'taxes';
    protected $primaryKey = 'tax_id';
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'name',
        'tax_code',
        'percent',
        'status',
        'is_default',
    ];

   
    public $sortable = [
        'user_id',
        'name',
        'percent',
        'is_default',
        'status',
    ];

  
}
