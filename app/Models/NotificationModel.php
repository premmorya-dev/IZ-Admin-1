<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class NotificationModel extends Model
{
    use HasFactory;
    use Sortable;

    protected $table = 'notifications';

    protected $primaryKey = 'notification_id';

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'invoice_id',
        'notification_type',
        'template_id',
        'is_read',
        'read_at',
        'content',
        'processing_status',
        'cron_start_datetime',
        'cron_end_datetime',
        'processing_log',
    ];

    public $sortable = [
        'user_id',
        'invoice_id',
        'notification_type',
        'template_id',
        'is_read',
        'read_at',
        'content',
        'processing_status',
        'cron_start_datetime',
        'cron_end_datetime',
        'processing_log',
        
    ];

  
}
