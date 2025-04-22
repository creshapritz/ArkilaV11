<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class DriverAdmin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'driver_admin';

    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'partner_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship with Partner
    public function partner()
    {
        return $this->belongsTo(PartnerAdmin::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

}
