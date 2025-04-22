<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class StaffAdmin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'staff_admin';

    protected $fillable = [
        'admin_id',
        'partner_id',
        'firstname',
        'lastname',
        'email',
        'password',
        'status',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

}
