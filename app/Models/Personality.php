<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Personality extends Model
{
    protected $fillable = [
        'family_branch_id',
        'full_name',
        'photo',
        'birth_gregorian',
        'birth_hijri',
        'location',
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

    public function branch(): BelongsTo
    {
        return $this->belongsTo(FamilyBranch::class, 'family_branch_id');
    }
}
