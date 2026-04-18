<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyMember extends Model
{
    protected $fillable = [
        'parent_id',
        'family_branch_id',
        'full_name',
        'short_name',
        'role',
        'year_range',
        'bio',
        'gender',
        'sort_order',
        'icon_key',
        'avatar',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_public' => 'boolean',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('sort_order');
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(FamilyBranch::class, 'family_branch_id');
    }
}
