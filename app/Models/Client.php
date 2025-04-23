<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Client extends Authenticatable implements CanResetPasswordContract
{
    use SoftDeletes;
    use HasFactory, Notifiable, CanResetPassword; 

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'extension_name',
        'age',
        'dob',
        'contact_number',
        'address',
        'emergency_contact',
        'emergency_contact_relationship',
        'username',
        'email',
        'password',
        'profile_picture',
        'driver_license_type',
        'service_type',
        'front_license',
        'back_license',
        'first_id_type',
        'front_first_id',
        'back_first_id',
        'second_id_type',
        'front_second_id',
        'back_second_id',
        'driver_front_second_id',
        'driver_back_second_id',
        'proof_of_billing_type',
        'proof_of_billing',
        'driver_proof_of_billing',
        'status',

    ];

    
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

  
    protected $hidden = ['password', 'remember_token'];


    public function favoriteDrivers()
    {
        return $this->belongsToMany(Driver::class, 'favorite_drivers')->withTimestamps();
    }
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
    protected $casts = [
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];


}
