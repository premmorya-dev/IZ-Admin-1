<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class WebhookJobQueue extends Model
{
    use HasFactory;
   
    protected $table = 'outgoing_webhook_job_queue';
    protected $primaryKey = 'outgoing_webhook_job_queue_id';
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'outgoing_webhook_job_queue_id',
        'outgoing_webhook_job_queue_content_type',
        'webhook_header_json',
        'registration_id',
        'webhook_url',
        'webhook_enabled',
        'webhook_status',
        'added_datetime',
        'queue_process_start_datetime',
        'queue_process_end_datetime',
        'webhook_log',
    
    ];

    public $sortable = [
        'outgoing_webhook_job_queue_id',
        'outgoing_webhook_job_queue_content_type',
        'webhook_header_json',
        'registration_id',
        'webhook_url',
        'webhook_enabled',
        'webhook_status',
        'added_datetime',
        'queue_process_start_datetime',
        'queue_process_end_datetime',
        'webhook_log',
        
    ];
}
