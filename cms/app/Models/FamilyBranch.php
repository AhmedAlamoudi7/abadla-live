<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FamilyBranch extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'sort_order',
        'member_count',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'member_count' => 'integer',
        ];
    }

    public function members(): HasMany
    {
        return $this->hasMany(FamilyMember::class);
    }

    public function personalities(): HasMany
    {
        return $this->hasMany(Personality::class);
    }
}
