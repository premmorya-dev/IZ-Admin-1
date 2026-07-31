<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'cover_image',
        'author_name',
        'author_role',
        'author_avatar',
        'reading_time',
        'published_at',
        'meta_title',
        'meta_description',
        'content',
        'status',
    ];

    protected $casts = [
        'published_at' => 'date:Y-m-d',
    ];
}