<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class ClientModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'clients';
    protected $primaryKey = 'client_id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'client_name',
        'client_code',
        'company_name',
        'email',
        'phone',
        'gst_number',
        'address_1',
        'address_2',
        'city',
        'state_id',
        'country_id',
        'zip',
        'notes',
        'terms',
        'status',
        'currency_code',
    ];

    public $sortable = [
        'user_id',
        'client_name',
        'company_name',
        'email',
        'phone',
        'gst_number',
        'address_1',
        'address_2',
        'city',
        'state_id',
        'country_id',
        'zip',
        'notes',
        'terms',
        'status',
        'currency_code',
        
    ];

  
}
