<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadModel extends Model
{
    protected $table = 'leads';

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'customer_name', 'email', 'phone', 'status', 'last_error'
    ];
}
