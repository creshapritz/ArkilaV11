<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GpsLocation;

class GpsLocationController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'car_id' => 'required|integer',
            'client_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        // Store or update the latest GPS location
        GpsLocation::updateOrCreate(
            ['car_id' => $request->car_id, 'client_id' => $request->client_id],
            ['latitude' => $request->latitude, 'longitude' => $request->longitude]
        );

        return response()->json(['status' => 'success']);
    }
}
