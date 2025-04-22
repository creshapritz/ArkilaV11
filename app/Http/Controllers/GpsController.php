<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GpsData;
use App\Models\Car;

class GpsController extends Controller
{
    // Store GPS data from the device
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'car_id' => 'required|integer',
            'client_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $gpsData = new GpsData($validatedData);
        $gpsData->save();

        return response()->json(['message' => 'GPS data updated successfully'], 200);
    }

    // Get the latest GPS data for each car
    public function index()
    {
        $gpsData = GpsData::select('car_id', 'client_id', 'latitude', 'longitude')
            ->orderBy('id', 'desc')
            ->get()
            ->unique('car_id') // Get only the latest entry for each car
            ->values(); // Reset keys

        return response()->json($gpsData);
    }

    // Get the latest GPS data for a specific car and client
    public function getLatestGps($carId, $clientId)
    {
        $latest = GpsData::where('car_id', $carId)
            ->where('client_id', $clientId)
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'latitude' => $latest->latitude ?? null,
            'longitude' => $latest->longitude ?? null,
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'car_id' => 'required|integer',
            'client_id' => 'required|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
    
        GpsData::create($validated);
    
        return response()->json(['message' => 'GPS data updated successfully'], 200);
    }
    

    // Get the current location of a car based on its stored latitude and longitude
    public function getCarLocation($carId)
    {
        $car = Car::find($carId);

        if ($car && $car->latitude && $car->longitude) {
            return response()->json([
                'latitude' => $car->latitude,
                'longitude' => $car->longitude
            ]);
        }

        return response()->json(['error' => 'Location not found'], 404);
    }
}
