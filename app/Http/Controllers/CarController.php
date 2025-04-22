<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Booking;

class CarController extends Controller
{
    public function searchCars(Request $request)
    {
        // Get dynamic filter values
        $types = Car::select('type')->distinct()->pluck('type');
        $capacities = Car::select('seating_capacity')->distinct()->pluck('seating_capacity');
        $transmissions = Car::select('transmission')->distinct()->pluck('transmission');
        $locations = Car::select('location')->distinct()->pluck('location');



        // Validate the request input
        $validated = $request->validate([
            'destination' => 'nullable|string|max:255',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'type' => 'nullable|string',
            'capacity' => 'nullable|integer|min:1',
            'transmission' => 'nullable|string',
            'location' => 'nullable|string',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0|gte:price_min',
        ]);

        $cars = Car::query();
        $cars = Car::where('archived', false)
            ->where('status', '!=', 'maintenance');






        if ($request->filled('start_date') && $request->filled('end_date')) {
            $cars->whereDoesntHave('bookings', function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                    ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            });
        }


        if ($request->filled('type')) {
            $cars->where('type', $validated['type']);
        }

        if ($request->filled('capacity')) {
            $cars->where('seating_capacity', $validated['capacity']);
        }

        if ($request->filled('transmission')) {
            $cars->where('transmission', $validated['transmission']);
        }

        if ($request->filled('location')) {
            $cars->where('location', 'LIKE', '%' . $validated['location'] . '%');
        }

        if ($request->filled('price_range')) {
            [$min, $max] = explode('-', $request->price_range);
            $cars->whereBetween('price_per_day', [(float) $min, (float) $max]);
        }


        $cars = $cars->get();


        return view('car_results', compact('cars', 'types', 'capacities', 'transmissions', 'locations'));
    }

    public function index()
    {
        $cars = Car::all();
        return view('cars.index', compact('cars'));
    }

    public function showCarDetails($id)
    {
        $car = Car::findOrFail($id);
        return view('client.car-details', compact('car'));
    }
    
   
}
