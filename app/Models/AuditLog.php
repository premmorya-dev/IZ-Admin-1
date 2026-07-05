<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';
    protected $primaryKey = 'audit_log_id';
    public $timestamps = true;

    protected $fillable = [
        'account_id',
        'user_id',
        'action',
        'model_type',
        'model_id',
        'ip_address',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];
}
