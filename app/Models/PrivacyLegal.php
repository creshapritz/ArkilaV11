<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyLegal extends Model
{
    use HasFactory;


    protected $table = 'privacylegal'; 
    protected $fillable = ['key', 'value'];
    public $timestamps = true;
}