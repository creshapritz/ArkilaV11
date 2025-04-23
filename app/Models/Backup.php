<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Backup extends Model
{
    protected $fillable = ['type', 'data'];

    protected $casts = [
        'data' => 'array',
    ];
}
