<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArchiveSubmission extends Model
{
    protected $fillable = [
        'type',
        'full_name',
        'phone_country',
        'phone_number',
        'email',
        'status',
        'admin_notes',
    ];
}
