<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ClientFavoriteController extends Controller
{
    public function toggleFavorite(Request $request)
    {
        $clientId = auth()->guard('client')->id(); // or however you get current client
        $driverId = $request->driver_id;

        $exists = DB::table('favorite_drivers')
            ->where('client_id', $clientId)
            ->where('driver_id', $driverId)
            ->exists();

        if ($exists) {
            DB::table('favorite_drivers')
                ->where('client_id', $clientId)
                ->where('driver_id', $driverId)
                ->delete();

            return response()->json(['status' => 'unfavorited']);
        } else {
            DB::table('favorite_drivers')->insert([
                'client_id' => $clientId,
                'driver_id' => $driverId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return response()->json(['status' => 'favorited']);
        }
    }


    public function index()
    {
        $client = Auth::guard('client')->user();
        $favorites = $client->favoriteDrivers()->with('partner')->get(); // Include related data if needed

        return view('client.favorites.index', compact('favorites'));
    }

    public function remove($driverId)
    {
        $clientId = auth()->guard('client')->id();

        DB::table('favorite_drivers')
            ->where('client_id', $clientId)
            ->where('driver_id', $driverId)
            ->delete();

        return redirect()->back()->with('success', 'Driver removed from favorites.');
    }

}
