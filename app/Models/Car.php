<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';

    protected $fillable = [
        'name',
        'brand',
        'type',
        'location',
        'price_per_day',
        'availability',
        'image',
        'seating_capacity',
        'num_bags',
        'gas_type',
        'transmission',
        'platenum',
        'mileage',
        'color',
        'regexpiry',
        'primary_image',
        'additional_image',
        'company_logo',
        'company_name',
        'partner_id',
        'status',
        
    ];

    protected $attributes = [
        'availability' => true,
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }



    public function scopeAvailable($query)
    {
        return $query->where('availability', true);
    }
    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }


}
