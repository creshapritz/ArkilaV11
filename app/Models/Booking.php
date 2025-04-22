<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Explicitly define the table name

    protected $fillable = [
        'car_id',
        'client_id',
        'pickup_location',
        'pickup_date',
        'pickup_time',
        'dropoff_location',
        'dropoff_date',
        'dropoff_time',
        'amount',
        'payment_reference',
        'status',
        'company_name',
        'car_name',
        'car_type',
        'driver_option',
        'driver_id',
        'latitude', 
        'longitude', 
        'usage_status',
    ];


    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    protected function pickupTime(): Attribute
    {
        return Attribute::make(
            set: fn($value) => date('H:i:s', strtotime($value))
        );
    }

    protected function dropoffTime(): Attribute
    {
        return Attribute::make(
            set: fn($value) => date('H:i:s', strtotime($value))
        );
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    




}
