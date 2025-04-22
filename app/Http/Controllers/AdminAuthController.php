<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\StaffAdmin;
use App\Models\Booking;
use App\Models\PartnerAdmin;
use App\Models\DriverAdmin;
use App\Models\Partner;
use Illuminate\Support\Facades\Log;




class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.adminlogin');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);


        $admin = Admin::where('email', $request->email)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return back()->withErrors(['error' => 'Invalid credentials.']);
        }


        if ($admin->status !== 'Active') {
            return back()->withErrors(['error' => 'Your account is inactive. Please contact support.']);
        }

        Auth::guard('admin')->login($admin);

        return redirect()->route('admin.dashboard');

    }
    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $admin = Admin::where('email', $credentials['email'])->first();

        if ($admin && !$admin->isActive()) {
            return false;
        }

        return auth()->attempt($credentials);
    }





    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.adminlogin');
    }



    public function dashboard()
    {
        if (Auth::guard('admin')->check()) {
            $admin = Auth::guard('admin')->user();
            $notifications = $admin->unreadNotifications;  
    
            return view('admin.admindashboard', [
                'admin' => $admin,
                'notifications' => $notifications
            ]);
        }
    
        return redirect()->route('admin.adminlogin');
    }
    

    public function index()
    {
        $admins = Admin::all();
        return view('admin.adminaccounts', compact('admins'));
    }

    public function show($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.show', compact('admin'));
    }







    public function store(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    if (
                        Admin::where('email', $value)->exists() ||
                        StaffAdmin::where('email', $value)->exists() ||
                        PartnerAdmin::where('email', $value)->exists() ||
                        DriverAdmin::where('email', $value)->exists()
                    ) {
                        $fail('The email is already taken.');
                    }
                },
            ],
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'role' => 'required|in:admin,staff,partner,driver',
            'partner_id' => 'required_if:role,partner|required_if:role,staff|required_if:role,driver',
        ]);
    
        $temporaryPassword = Str::random(10);
    
        $data = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($temporaryPassword),
            'status' => 'Active',
            'role' => $request->role,
        ];
    
        $admin = Admin::create($data);
    
        switch ($request->role) {
            case 'partner':
                PartnerAdmin::create([
                    'admin_id' => $admin->id,
                    'partner_id' => $request->partner_id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($temporaryPassword),
                    'status' => 'Active',
                ]);
                Log::info('Partner admin created.');
                break;
    
            case 'staff':
                StaffAdmin::create([
                    'admin_id' => $admin->id,
                    'partner_id' => $request->partner_id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($temporaryPassword),
                    'status' => 'Active',
                ]);
                Log::info('Staff admin created.');
                break;
    
            case 'driver':
                DriverAdmin::create([
                    'partner_id' => $request->partner_id,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'email' => $request->email,
                    'password' => Hash::make($temporaryPassword),
                    'status' => 'Active',
                ]);
                Log::info('Driver admin created.');
                break;
    
            case 'admin':
                Log::info('Admin account created.');
                break;
        }
    
        $loginUrl = match ($request->role) {
            'admin' => url('/admin/login'),
            'staff' => url('/staff_admin/login'),
            'partner' => url('/partners_admin/login'),
            'driver' => url('/driver_admin/login'),
            default => url('/login'),
        };
    
        try {
            Mail::to($request->email)->send(new \App\Mail\AccountCreatedMail(
                $request->email,
                $temporaryPassword,
                $loginUrl
            ));
            Log::info("Email sent to: " . $request->email);
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$request->email}: " . $e->getMessage());
        }
    
        return redirect()->route('admin.index')->with('success', 'Account created and login details sent to email.');
    }
    


    public function toggleStatus($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->status = ($admin->status === 'Active') ? 'Inactive' : 'Active';
        $admin->save();

        return redirect()->back()->with('success', 'Admin status updated successfully.');
    }


    public function create()
    {
        $partners = Partner::all(); // Get all partner companies

        return view('admin.create', compact('partners'));
    }



    public function archive($id)
    {
        $admin = Admin::findOrFail($id);


        $admin->status = 'Archived';
        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Admin archived successfully!');
    }

    public function unarchive($id)
    {
        $admin = Admin::findOrFail($id);


        $admin->status = 'Active';
        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Admin unarchived successfully!');
    }
    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);
        $admin->update([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'role' => $request->role,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Admin details updated successfully.');
    }



    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = null;


        if ($request->role === 'admin') {
            $user = Admin::where('email', $request->email)->first();
        } elseif ($request->role === 'staff') {
            $user = StaffAdmin::where('email', $request->email)->first();
        } elseif ($request->role === 'partner') {
            $user = PartnerAdmin::where('email', $request->email)->first();
        } elseif ($request->role === 'driver') {
            $user = DriverAdmin::where('email', $request->email)->first();
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials.']);
        }
        if (isset($user->status) && strtolower($user->status) !== 'active') {
            return back()->withErrors(['email' => 'Your account is inactive. Please contact the administrator.']);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }







}
