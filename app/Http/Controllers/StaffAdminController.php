<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StaffAdmin;

class StaffAdminController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('staff_admin.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('staff_admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('staff_admin.dashboard');
        }

        return back()->withErrors(['error' => 'Invalid login credentials.']);
    }

    // Show the dashboard
    public function dashboard()
    {
        $totalClients = \App\Models\Client::count();
        $totalDrivers = \App\Models\Driver::count();
        $totalPartners = \App\Models\PartnerAdmin::count();
        return view('staff_admin.dashboard', compact('totalClients', 'totalDrivers', 'totalPartners'));
    }

    // Handle logout
    public function logout()
    {
        Auth::guard('staff_admin')->logout();
        return redirect()->route('staff_admin.login');
    }
}
