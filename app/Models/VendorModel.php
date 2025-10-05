<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class VendorModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'vendors';
    protected $primaryKey = 'vendor_id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
        'user_id',
        'vendor_code',
        'vendor_name',
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
        'status',
         'currency_code'
    ];
    public $sortable = [
       'user_id',
        'vendor_code',
        'vendor_name',
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
        'status',
         'currency_code'
        
    ];

  
}
