<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsPost extends Model
{
    public const TYPE_NEWS = 'news';

    public const TYPE_ARTICLE = 'article';

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'published_at',
        'category',
        'type',
        'tags',
        'is_breaking',
        'show_on_home',
        'layout_role',
        'mosaic_slot',
        'is_hourly_featured',
        'important_sort',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'tags' => 'array',
            'published_at' => 'datetime',
            'is_breaking' => 'boolean',
            'show_on_home' => 'boolean',
            'is_hourly_featured' => 'boolean',
            'published' => 'boolean',
            'important_sort' => 'integer',
        ];
    }
}
