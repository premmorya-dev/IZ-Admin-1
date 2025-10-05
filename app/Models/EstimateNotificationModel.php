<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class EstimateNotificationModel extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'estimate_notifications';

    protected $primaryKey = 'notification_id';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'estimate_id',
        'notification_type',
        'template_id',
        'is_read',
        'read_at',
        'content',
        'processing_status',
        'cron_start_datetime',
        'cron_end_datetime',
        'processing_log',
        'estimate_code',
    ];

    public $sortable = [
        'user_id',
        'estimate_id',
        'notification_type',
        'template_id',
        'is_read',
        'read_at',
        'content',
        'processing_status',
        'cron_start_datetime',
        'cron_end_datetime',
        'processing_log',
        'estimate_code',

    ];
}
