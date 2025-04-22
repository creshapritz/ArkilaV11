<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_owner',
        'company_email',
        'company_name',
        'company_phone',
        'company_logo',
        'company_document',
        'status',
    ];

    public function partnerAdmins()
    {
        return $this->hasMany(PartnerAdmin::class);
    }

}