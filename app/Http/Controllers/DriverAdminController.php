<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DriverAdminController extends Controller
{
    
    public function showLoginForm()
    {
        return view('driver_admin.login');
    }

    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('driver_admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('driver_admin.dashboard');
        }

        return back()->withErrors(['error' => 'Invalid login credentials.']);
    }

   
    public function dashboard()
    {
        $driver = Auth::guard('driver_admin')->user();
        return view('driver_admin.dashboard', compact('driver'));
    }

    // Handle logout
    public function logout()
    {
        Auth::guard('driver_admin')->logout();
        return redirect()->route('driver_admin.login');
    }
}
