<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverRating extends Model
{
    protected $fillable = [
        'client_id',
        'driver_id',
        'rating',
        'comment',
    ];

    public function client()
{
    return $this->belongsTo(\App\Models\Client::class);
}

}
