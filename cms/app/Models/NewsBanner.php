<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsBanner extends Model
{
    protected $fillable = [
        'slot',
        'image',
        'caption',
        'link',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'slot' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
