<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = ['email', 'password', 'firstname', 'lastname', 'role', 'date_created', 'status'];



    public function partnerAdmin()
    {
        return $this->hasOne(PartnerAdmin::class);
    }

    public function isActive()
    {
        return $this->status === 'Active';
    }


}
