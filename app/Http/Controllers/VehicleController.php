<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Car; // Use the Car model
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Partner;
use App\Models\PartnerAdmin;

class VehicleController extends Controller
{

    public function add()
    {
        $partners = PartnerAdmin::with('partner')->get(); // Eager load the partner
        return view('admin.add-vehicle', compact('partners'));
    }
    

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'partner_id' => 'required|exists:partner_admins,id',
            'brand' => 'required|string',
            'type' => 'required|string',
            'location' => 'required|string',
            'price_per_day' => 'required|numeric',
            'seating_capacity' => 'required|integer',
            'gas_type' => 'required|string',
            'transmission' => 'required|string',
            'num_bags' => 'required|integer|min:0',
            'platenum' => 'nullable|string',
            'mileage' => 'nullable|integer',
            'color' => 'nullable|string',
            'availability' => 'nullable|date_format:Y-m-d',
            'regexpiry' => 'nullable|date',
            'primary_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'additional_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
    
        // Fetch PartnerAdmin
        $partnerAdmin = PartnerAdmin::findOrFail($request->partner_id);
    
        // Fetch Partner from PartnerAdmin
        $partner = $partnerAdmin->partner;
    
        // Assign the car to the correct partner_id
        $car = new Car();
        $car->name = $request->name;
        $car->brand = $request->brand;
        $car->type = $request->type;
        $car->location = $request->location;
        $car->price_per_day = $request->price_per_day;
        $car->seating_capacity = $request->seating_capacity;
        $car->gas_type = $request->gas_type;
        $car->transmission = $request->transmission;
        $car->num_bags = $request->num_bags;
        $car->platenum = $request->platenum;
        $car->mileage = $request->mileage;
        $car->color = $request->color;
        $car->regexpiry = $request->regexpiry;
        $car->partner_id = $partner->id;  // Use Partner's ID here
        $car->company_name = $partner->company_name ?? 'Unknown';
    
        // Save images if present
        if ($request->hasFile('primary_image')) {
            $file = $request->file('primary_image');
            $filename = time() . '_primary_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cars/primary'), $filename);
            $car->primary_image = 'uploads/cars/primary/' . $filename;
        }
    
        if ($request->hasFile('company_logo')) {
            $file = $request->file('company_logo');
            $filename = time() . '_logo_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/cars/logos'), $filename);
            $car->company_logo = 'uploads/cars/logos/' . $filename;
        }
    
        $car->save();
    
        if ($request->hasFile('additional_image')) {
            $additionalPaths = [];
            foreach ($request->file('additional_image') as $index => $image) {
                $filename = time() . "_additional_{$index}_" . $image->getClientOriginalName();
                $image->move(public_path('uploads/cars/additional'), $filename);
                $additionalPaths[] = 'uploads/cars/additional/' . $filename;
            }
            $car->additional_image = json_encode($additionalPaths);
            $car->save();
        }
    
        return redirect()->route('vehicles.list')->with('success', 'Car added successfully!');
    }
    





    public function list()
    {
        $cars = Car::where('status', '!=', 'maintenance')
            ->where('archived', '!=', true)
            ->get();

        return view('admin.list-vehicle', compact('cars'));
    }


    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('admin.car-details', compact('car'));
    }



    public function destroy($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json(['success' => 'Vehicle not found.'], 404);
        }

        $car->archived = true;
        $car->save();

        return response()->json(['success' => 'Vehicle archived successfully.']);
    }
    public function archive($id)
    {
        $car = Car::find($id);

        if (!$car) {
            return response()->json(['success' => 'Vehicle not found.'], 404);
        }

        $car->archived = true;
        $car->save();

        return response()->json(['success' => 'Vehicle archived successfully.']);
    }


    public function index()
    {
        $cars = Car::all();
        $admin = Auth::guard('admin')->user();
        return view('admin.admindashboard', compact('cars', 'admin'));
    }

    public function maintenance()
    {
        $cars = Car::where('status', 'maintenance')->get();
        return view('admin.list-vehicle', compact('cars'));
    }

    public function archived()
    {
        $cars = Car::where('archived', true)->get();
        return view('admin.list-vehicle', compact('cars'));
    }




    public function filterCars(Request $request)
    {

        $query = Car::query();


        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        if ($request->filled('color')) {
            $query->where('color', $request->input('color'));
        }

        if ($request->filled('availability')) {
            $availability = $request->input('availability');
            if ($this->isValidDate($availability)) {
                $query->whereDate('availability', '>=', $availability);
            }
        }



        $cars = $query->get();



        return view('admin.admindashboard', compact('cars'));
    }



    private function isValidDate($date)
    {
        return (bool) strtotime($date);
    }
    public function updateStatus(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->status = $request->status;
        $car->save();

        return response()->json(['success' => 'Vehicle status updated successfully.']);
    }




}

