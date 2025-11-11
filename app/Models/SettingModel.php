<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;


class SettingModel extends Model
{
    use HasFactory;
    use Sortable;
    protected $table = 'settings';
    protected $primaryKey = 'setting_id';
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'setting_id',
        'user_id',
        'logo_path',
        'mobile_no',
        'mobile_country_code_id',
        'default_currency',
        'default_upi_id',
        'default_tax_percent',
        'invoice_prefix',
        'estimate_prefix',
        'expense_prefix',
        'invoice_start_number',
        'company_footer',
        'email',
        'signature',
        'pagination_limit',
        'company_name',
        'is_company',
        'address_1',
        'address_2',
        'state_id',
        'country_id',
        'pincode',
        'notes',
        'terms',
        'date_format',
        'invoice_payment_reminder_status',
        'reminder_before_due_days',
        'everyday_reminder_after_due_day',
        'shipping_status',
        'user_gst_number',
        'display_gst_number'
    ];

    public $sortable = [];
}
