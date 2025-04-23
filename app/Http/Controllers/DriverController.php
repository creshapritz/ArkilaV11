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

      
        $uploadPath = public_path('uploads/driver_docs');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true); // Create the directory if it doesn't exist
        }
        
        // Profile Picture
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validatedData['profile_picture'] = 'uploads/driver_docs/' . $filename;
        }
        
        // License Front
        if ($request->hasFile('license_front')) {
            $file = $request->file('license_front');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validatedData['license_front'] = 'uploads/driver_docs/' . $filename;
        }
        
        // License Back
        if ($request->hasFile('license_back')) {
            $file = $request->file('license_back');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validatedData['license_back'] = 'uploads/driver_docs/' . $filename;
        }
        
        // Second ID Front
        if ($request->hasFile('second_id_front')) {
            $file = $request->file('second_id_front');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validatedData['second_id_front'] = 'uploads/driver_docs/' . $filename;
        }
        
        // Second ID Back
        if ($request->hasFile('second_id_back')) {
            $file = $request->file('second_id_back');
            $filename = uniqid() . '_' . $file->getClientOriginalName();
            $file->move($uploadPath, $filename);
            $validatedData['second_id_back'] = 'uploads/driver_docs/' . $filename;
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
