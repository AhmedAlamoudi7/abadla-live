<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SocialCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'icon_image',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }

    public function occasions(): HasMany
    {
        return $this->hasMany(SocialOccasion::class);
    }
}
