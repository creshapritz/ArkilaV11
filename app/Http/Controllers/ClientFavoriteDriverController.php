<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DriverRating;

class ClientFavoriteDriverController extends Controller
{
    public function index()
    {
        $clientId = auth()->guard('client')->id();
    
        $favoriteDrivers = DB::table('favorite_drivers')
            ->join('drivers', 'favorite_drivers.driver_id', '=', 'drivers.id')
            ->where('favorite_drivers.client_id', $clientId)
            ->select('drivers.id', 'drivers.name', 'drivers.contact_number as contact', 'drivers.profile_picture as picture')
            ->get();
    
        return view('client.favorites.index', compact('favoriteDrivers'));
    }
    
   

}
