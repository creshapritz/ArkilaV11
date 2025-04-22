<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DriverBooking extends Model
{
    protected $fillable = [
        'booking_id',
        'driver_id',
        'partner_id',
        'num_days',
        'total_driver_fee',
        'status'
    ];

    public function booking() {
        return $this->belongsTo(Booking::class);
    }

    public function driver() {
        return $this->belongsTo(Driver::class);
    }
}
