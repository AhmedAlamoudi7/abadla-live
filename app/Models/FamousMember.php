<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FamousMember extends Model
{
    protected $fillable = [
        'name',
        'line_one',
        'line_two',
        'photo',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
        ];
    }
}
