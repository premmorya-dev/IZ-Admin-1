<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceSequence extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'invoice_sequences';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'sequence_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'prefix',
        'padding',
        'start_from',
        'next_number',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id'     => 'integer',
        'padding'     => 'integer',
        'start_from'  => 'integer',
        'next_number' => 'integer',
    ];

    /**
     * Default attribute values.
     *
     * @var array<string, mixed>
     */
    protected $attributes = [
        'prefix'      => 'INV-',
        'padding'     => 4,
        'start_from'  => 1,
        'next_number' => 1,
    ];

    /**
     * Get the owner of the invoice sequence.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Return the next formatted invoice number.
     *
     * Example: INV-0001
     */
    public function preview(): string
    {
        return $this->prefix . str_pad(
            $this->next_number,
            $this->padding,
            '0',
            STR_PAD_LEFT
        );
    }

    /**
     * Return a formatted invoice number.
     */
    public function format(int $number): string
    {
        return $this->prefix . str_pad(
            $number,
            $this->padding,
            '0',
            STR_PAD_LEFT
        );
    }
}