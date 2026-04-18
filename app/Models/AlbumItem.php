<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlbumItem extends Model
{
    protected $fillable = [
        'album_category_id',
        'image',
        'caption',
        'sort_order',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'published' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(AlbumCategory::class, 'album_category_id');
    }
}
