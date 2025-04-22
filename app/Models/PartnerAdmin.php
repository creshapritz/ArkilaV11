<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class PartnerAdmin extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'id',
        'partner_id',
        'firstname',
        'email',
        'password',
        'password_status', 
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];




    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class, 'partner_id');
    }

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }


}
