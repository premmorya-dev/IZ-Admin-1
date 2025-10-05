<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class EstimateModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'estimates';

    // The primary key associated with the table.
    protected $primaryKey = 'estimate_id';
    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // The attributes that are mass assignable.
    protected $fillable = [
        'user_id',
        'client_id',
        'estimate_code',
        'estimate_number',
        'issue_date',
        'expiry_date',
        'status',
        'sub_total',
        'total_tax',
        'total_discount',
        'grand_total',
        'notes',
        'terms',
        'currency_code',
        'sent_at',
        'item_json',
        'template_id',
    ];

    public $sortable = [
        'user_id',
        'client_id',
        'estimate_code',
        'estimate_number',
        'issue_date',
        'expiry_date',
        'status',
        'sub_total',
        'total_tax',
        'total_discount',
        'grand_total',
        'notes',
        'terms',
        'currency_code',
        'sent_at',
        'item_json',
        'template_id',

    ];
}
