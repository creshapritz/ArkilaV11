<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Support\Facades\Mail;


class PartnerVehicleController extends Controller
{
    public function index()
    {
        $cars = Car::where('partner_id', auth()->user()->partner_id)->get();
        return view('partners_admin.cars.index', compact('cars'));
    }



    public function create()
    {
        return view('partners_admin.cars.create');
    }



    public function updateStatus(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->status = $request->status;
        $car->save();

        return response()->json(['success' => 'Status updated successfully.']);
    }

    public function archive($id)
    {
        $car = Car::findOrFail($id);
        $car->archived = true;
        $car->save();

        return response()->json(['success' => 'Car archived successfully.']);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'price_per_day' => 'required|numeric',
            'seating_capacity' => 'required|integer',
            'num_bags' => 'required|integer',
            'gas_type' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'platenum' => 'required|string|max:255',
            'mileage' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'regexpiry' => 'required|date',
            'company_name' => 'required|string|max:255',
            'receiver_email' => 'required|email',
            'sender_email' => 'required|email',
        ]);


        $carRequestData = $request->only([
            'name',
            'brand',
            'type',
            'location',
            'price_per_day',
            'seating_capacity',
            'num_bags',
            'gas_type',
            'transmission',
            'platenum',
            'mileage',
            'color',
            'regexpiry',
            'company_name'
        ]);


        Mail::to($request->receiver_email)
            ->send(new \App\Mail\NewCarRequest($carRequestData, $request->sender_email));

        // Redirect with a success message
        return redirect()->route('partners_admin.cars.index')->with('success', 'Car request has been submitted and emailed successfully.');
    }


}
