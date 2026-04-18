<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    protected $fillable = [
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
}
