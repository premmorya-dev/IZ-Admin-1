<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class ContactModel extends Model
{
    use HasFactory;
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'contacts';
    protected $primaryKey = 'contact_id';
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
    ];


    public $sortable = [
        'user_id',
        'name',
        'percent',
        'is_default',
        'status',
    ];
}
