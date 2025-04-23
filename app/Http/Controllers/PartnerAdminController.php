<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Client;
use FPDF;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Driver;
use App\Models\DriverAdmin;
use App\Models\Partner;
use App\Models\Admin;
use App\Notifications\NewDriverCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
date_default_timezone_set('Asia/Manila');

class PartnerAdminController extends Controller
{



    public function showLoginForm()
    {
        return view('partners_admin.login');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('partner_admin')->attempt($request->only('email', 'password'))) {
            $partnerAdmin = Auth::guard('partner_admin')->user();


            if ($partnerAdmin->password_status === 'temporary') {
                return redirect()->route('partner_admin.showChangePasswordForm');
            }

            return redirect()->route('partners_admin.dashboard');
        }

        return back()->withErrors(['error' => 'Invalid login credentials.']);
    }
    public function showChangePasswordForm()
    {
        return view('partner_admin.auth.change-password');
    }




    public function updatePassword(Request $request)
    {

        $partnerAdmin = Auth::guard('partner_admin')->user();
        if (!$partnerAdmin) {
            return redirect()->route('partner_admin.login')->withErrors(['error' => 'Please log in first.']);
        }

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $partnerAdmin->password = Hash::make($request->password);
        $partnerAdmin->password_status = 'permanent';
        $partnerAdmin->save();


        Auth::guard('partner_admin')->logout();


        return redirect()->route('partners_admin.login')->with('success', 'Password updated successfully. Please log in again.');
    }




    public function dashboard(Request $request)
    {
        $partner = Auth::guard('partner_admin')->user()->partner;

        if (!$partner) {
            return back()->with('error', 'You are not associated with any partner.');
        }


        $cars = Car::where('partner_id', $partner->id)
            ->when($request->filled('type'), fn($q) => $q->where('type', $request->type))
            ->when($request->filled('brand'), fn($q) => $q->where('brand', $request->brand))
            ->when($request->filled('color'), fn($q) => $q->where('color', $request->color))
            ->get();

        // Get total unique clients for this partner using simpler query
        $totalClients = Booking::whereHas('car', function ($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        })->distinct('client_id')->count('client_id');

        return view('partners_admin.dashboard', compact('cars', 'totalClients'));
    }


    public function showVehicle($id)
    {
        $partner = Auth::guard('partner_admin')->user()->partner;

        // Ensure car exists and belongs to the authenticated partner
        $car = Car::where('id', $id)->where('partner_id', $partner->id)->first();

        if (!$car) {
            return back()->with('error', 'Car not found or you are not authorized to view this car.');
        }

        return view('partners_admin.cars.show', compact('car'));
    }

    public function showCar($id)
    {
        $partner = Auth::guard('partner_admin')->user()->partner;

        if (!$partner) {
            return back()->with('error', 'You are not associated with any partner.');
        }

        $car = Car::where('id', $id)->where('partner_id', $partner->id)->first();

        if (!$car) {
            return back()->with('error', 'Car not found or does not belong to your company.');
        }

        return view('partners_admin.cars.show', compact('car'));
    }
    public function showChecklist($id)
    {
        $booking = Booking::with(['client', 'car'])->findOrFail($id);
        return view('partners_admin.checklist', compact('booking'));
    }
    public function submitChecklist(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $checklist = $request->input('items', []);
        $booking->update([
            'checklist' => json_encode($checklist),
        ]);

        return redirect()->route('partners_admin.bookings')->with('success', 'Checklist submitted successfully!');
    }





    public function generateChecklistPdf($id)
    {
        $booking = Booking::with('car', 'client')->findOrFail($id);

        $pdf = Pdf::loadView('partners_admin.bookings.checklist_pdf', compact('booking'))
            ->setPaper('a4', 'landscape');


        return $pdf->stream('checklist.pdf');
    }


    public function logout()
    {
        Auth::guard('partner_admin')->logout();
        session()->flush();
        return redirect()->route('partners_admin.login');
    }


    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status = $request->input('status');
        $booking->save();

        return back()->with('success', 'Booking status updated successfully!');
    }

    public function transactionHistory()
    {
        $partnerAdmin = Auth::guard('partner_admin')->user();
        $companyName = $partnerAdmin->partner->company_name ?? null;

        $bookings = Booking::with('client', 'car')
            ->whereIn('status', ['Partially Paid', 'Paid', 'Returned'])
            ->whereHas('car', function ($query) use ($companyName) {
                $query->where('company_name', $companyName);
            })
            ->latest()
            ->paginate(10);

        return view('partners_admin.transaction_history', compact('bookings'));
    }




    public function partnerBookings(Request $request)
    {
        $partner = Auth::guard('partner_admin')->user()->partner;

        if (!$partner) {
            return back()->with('error', 'You are not associated with any partner. Please contact support.');
        }


        $query = Booking::whereHas('car', function ($q) use ($partner) {
            $q->where('partner_id', $partner->id);
        });


        if ($request->filled('company_name')) {
            $query->whereHas('car', function ($q) use ($request) {
                $q->where('company_name', $request->company_name);
            });
        }

        $bookings = $query->get();


        $companyNames = Car::where('partner_id', $partner->id)
            ->distinct()
            ->pluck('company_name');

        return view('partners_admin.bookings.index', compact('bookings', 'companyNames'));
    }

    public function cars()
    {
        $partnerAdmin = Auth::guard('partner_admin')->user();


        $cars = Car::where('partner_id', $partnerAdmin->partner_id)->get();

        return view('partners_admin.cars.index', compact('cars'));
    }

    public function show($id)
    {

        $partnerAdmin = Auth::guard('partner_admin')->user();

        // Fetch the client associated with the partner's partner_id
        $client = Client::where('id', $id)
            ->whereIn('id', function ($query) use ($partnerAdmin) {
                $query->select('client_id')
                    ->from('bookings')
                    ->join('cars', 'bookings.car_id', '=', 'cars.id')
                    ->where('cars.partner_id', $partnerAdmin->partner_id);
            })
            ->firstOrFail();


        return view('partners_admin.clients.show', compact('client'));
    }
   
    public function index()
    {
     
        $partnerId = auth()->guard('partner_admin')->user()->partner_id;

    
        $drivers = Driver::where('partner_id', $partnerId)->get();

     
        return view('partners_admin.drivers.index', compact('drivers'));
    }
    public function clients()
    {
        $partner = auth('partner_admin')->user();

        $clients = Client::whereIn('id', function ($query) use ($partner) {
            $query->select('client_id')
                ->from('bookings')
                ->join('cars', 'bookings.car_id', '=', 'cars.id')
                ->where('cars.partner_id', $partner->partner_id);
        })->get();

        return view('partners_admin.clients.index', compact('clients'));
    }
    public function drivers()
    {
        $partnerAdmin = Auth::guard('partner_admin')->user();

        $driverAdmins = DriverAdmin::where('partner_id', $partnerAdmin->partner_id)->get();


        $drivers = Driver::whereIn('id', $driverAdmins->pluck('id'))->get();

        return view('partners_admin.drivers.index', compact('drivers'));
    }


    public function showDriver($id)
    {
        $partnerAdmin = Auth::guard('partner_admin')->user();


        $driver = Driver::where('drivers.id', $id)
            ->whereIn('drivers.id', function ($query) use ($partnerAdmin) {
                $query->select('bookings.driver_id')
                    ->from('bookings')
                    ->join('cars', 'bookings.car_id', '=', 'cars.id')
                    ->where('cars.partner_id', $partnerAdmin->partner_id);
            })
            ->firstOrFail();

        return view('partners_admin.drivers.show', compact('driver'));
    }

    public function archiveDriver($id)
    {
        $partnerAdmin = Auth::guard('partner_admin')->user();


        $driver = Driver::where('partner_id', $partnerAdmin->partner_id)->where('id', $id)->firstOrFail();

        $driver->status = 'Archived';
        $driver->save();
        return redirect()->route('partners_admin.drivers.index')->with('success', 'Driver has been archived.');
    }


    public function createDriver()
    {
        $driverAdmins = DriverAdmin::all();
        $partners = Partner::all();
        return view('partners_admin.drivers.create', compact('driverAdmins', 'partners'));
    }



    public function storeDriver(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:20',
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'license_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'license_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'second_id_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'second_id_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $driver = new Driver();
        $driver->name = $request->input('name');
        $driver->email = $request->input('email');
        $driver->contact_number = $request->input('contact_number');

        // Get partner_id from the logged-in partner_admin
        $partnerId = auth()->guard('partner_admin')->user()->partner_id;
        $partner = Partner::findOrFail($partnerId);

        $driver->partner_id = $partnerId;
        $driver->company_name = $partner->company_name;

        // Handle file uploads
        $driver->profile_picture = $this->uploadFile($request, 'profile_picture');
        $driver->license_front = $this->uploadFile($request, 'license_front');
        $driver->license_back = $this->uploadFile($request, 'license_back');
        $driver->second_id_front = $this->uploadFile($request, 'second_id_front');
        $driver->second_id_back = $this->uploadFile($request, 'second_id_back');

        // Save the driver
        $driver->save();

       
        $superAdmins = Admin::where('role', 'admin')->get();
        Notification::send($superAdmins, new NewDriverCreated($driver));

       
        return redirect()->route('partner_admin.drivers.index')
            ->with('success', 'Driver created and notification sent to Super Admin.');
    }
    private function uploadFile(Request $request, $field)
    {
        if ($request->hasFile($field)) {
            $file = $request->file($field);
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/drivers'), $filename);
            return 'uploads/drivers/' . $filename;
        }
        return null;
    }














}
