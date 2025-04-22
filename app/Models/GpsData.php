<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GpsData extends Model
{
    protected $table = 'gps_data'; // Specify the table name
    protected $fillable = ['car_id', 'client_id', 'latitude', 'longitude'];
    public $timestamps = false; // We'll manage timestamps manually

    // Define relationships to Car and Client models if you have them
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
