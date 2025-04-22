<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use Illuminate\Support\Facades\Storage;

class DriverController extends Controller
{



    public function index()
    {
        $drivers = Driver::all();
        return view('admin.drivers.index', compact('drivers'));
    }


    public function create()
    {
        $partners = \App\Models\Partner::all();
        $driverAdmins = \App\Models\DriverAdmin::all();

        return view('admin.drivers.add-driver', compact('partners', 'driverAdmins'));
    }




    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'partner_id' => 'required|exists:partners,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:drivers',
            'contact_number' => 'required|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'license_front' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'license_back' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'second_id_front' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'second_id_back' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Optional: You can base64 encode or just get original filenames
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $validatedData['profile_picture'] = $file->getClientOriginalName(); // or base64_encode(file_get_contents($file))
        }

        if ($request->hasFile('license_front')) {
            $file = $request->file('license_front');
            $validatedData['license_front'] = $file->getClientOriginalName(); // or base64_encode(file_get_contents($file))
        }

        if ($request->hasFile('license_back')) {
            $file = $request->file('license_back');
            $validatedData['license_back'] = $file->getClientOriginalName();
        }

        if ($request->hasFile('second_id_front')) {
            $file = $request->file('second_id_front');
            $validatedData['second_id_front'] = $file->getClientOriginalName();
        }

        if ($request->hasFile('second_id_back')) {
            $file = $request->file('second_id_back');
            $validatedData['second_id_back'] = $file->getClientOriginalName();
        }

        // Optional: save to DB just the name or whatever info you want
        $partner = \App\Models\Partner::find($request->partner_id);
        if ($partner) {
            $validatedData['company_name'] = $partner->company_name;
        }

        Driver::create($validatedData);

        return redirect()->route('admin.drivers.index')->with('success', 'Driver added successfully (files not stored)!');
    }



    public function show($id)
    {
        $driver = Driver::findOrFail($id);
        return view('admin.drivers.show', compact('driver'));
    }



    public function archive($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = 'Archived';
        $driver->save();

        return redirect()->route('admin.drivers.index')->with('success', 'Driver archived successfully!');
    }
    public function toggleStatus($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->status = $driver->status === 'Active' ? 'Inactive' : 'Active';
        $driver->save();

        return response()->json(['status' => $driver->status]);
    }

}
