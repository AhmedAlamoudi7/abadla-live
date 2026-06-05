<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SocialOccasion extends Model
{
    protected $fillable = [
        'social_category_id',
        'title',
        'slug',
        'occurred_on',
        'image',
        'images',
        'excerpt',
        'body',
        'published',
    ];

    protected function casts(): array
    {
        return [
            'occurred_on' => 'date',
            'images' => 'array',
            'published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (SocialOccasion $occasion): void {
            if (empty($occasion->slug) && ! empty($occasion->title)) {
                $occasion->slug = static::uniqueSlug($occasion->title, $occasion->id);
            }
        });
    }

    /**
     * Build a unique, Arabic-friendly slug (language=null preserves Unicode letters).
     */
    protected static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title, '-', null);
        if ($base === '') {
            $base = 'occasion';
        }

        $slug = $base;
        $i = 2;
        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(SocialCategory::class, 'social_category_id');
    }
}
