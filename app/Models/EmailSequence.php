<?php

namespace App\Models;

use App\Enums\EmailType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmailSequence extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT    = 'sent';
    public const STATUS_SKIPPED = 'skipped';
    public const STATUS_FAILED  = 'failed';

    protected $fillable = [
        'user_id',
        'type',
        'status',
        'scheduled_at',
        'sent_at',
        'error',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at'      => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeOfType($query, EmailType $type)
    {
        return $query->where('type', $type->value);
    }
}
