<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class UpiIdModel extends Model
{
    use HasFactory;



    protected $table = 'upi_payment_id';
    protected $primaryKey = 'upi_log_id';
    public $timestamps = false;

    protected $fillable = [
        'upi_name',
        'upi_id',
        'status',
        'user_id'
    ];
}
