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
        'client_code',
        'client_name',
        'shipping_client_name',
        'company_name',
        'email',
        'phone',
        'shipping_phone',
        'gst_number',
        'address_1',
        'address_2',
        'shipping_address_1',
        'shipping_address_2',
        'city',
        'shipping_city',
        'state_id',
        'shipping_state_id',
        'country_id',
        'shipping_country_id',
        'zip',
        'shipping_zip',
        'notes',
        'terms',
        'status',
        'currency_code',
    ];

    public $sortable = [
        'user_id',
        'client_code',
        'client_name',
        'shipping_client_name',
        'company_name',
        'email',
        'phone',
        'shipping_phone',
        'gst_number',
        'address_1',
        'address_2',
        'shipping_address_1',
        'shipping_address_2',
        'city',
        'shipping_city',
        'state_id',
        'shipping_state_id',
        'country_id',
        'shipping_country_id',
        'zip',
        'shipping_zip',
        'notes',
        'terms',
        'status',
        'currency_code',

    ];
}
