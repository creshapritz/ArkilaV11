<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\GpsData;

class AdminBookingsController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['client', 'car'])
    ->latest()
    ->paginate(10); 

    return view('admin.bookings.index', compact('bookings'));
    }

  
    public function show($id)
    {

        $booking = Booking::with(['client', 'car'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }
    public function gpsTracking($bookingId)
    {
        $booking = Booking::with(['client', 'car'])->findOrFail($bookingId);
        return view('admin.gps-tracking', compact('booking'));
    }
    
    public function gpsMonitor()
    {
        return view('admin.gps-monitor');
    }
    
    public function gpsData()
    {
        $data = GpsData::latest('id')
            ->groupBy(['car_id', 'client_id']) // get latest per pair
            ->get(['car_id', 'client_id', 'latitude', 'longitude']); // keep it light
    
        return response()->json($data);
    }
    

}
