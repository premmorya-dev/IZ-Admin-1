<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class PlanModel extends Model
{
    use HasFactory;
    use Sortable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'plans';
    protected $primaryKey = 'plan_id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'price',
        'invoice_limit',
        'client_limit',
        'duration_days',
        'features',
        'is_active',
    ];

   
    public $sortable = [
        'name',
        'price',
        'invoice_limit',
        'client_limit',
        'duration_days',
        'features',
        'is_active',
    ];

  
}
