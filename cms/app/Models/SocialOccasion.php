<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialOccasion extends Model
{
    protected $fillable = [
        'social_category_id',
        'title',
        'occurred_on',
        'image',
        'excerpt',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'occurred_on' => 'date',
            'published' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SocialCategory::class, 'social_category_id');
    }
}
