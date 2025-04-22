<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;


class PartnersAdminBookingController extends Controller
{
    public function updateUsageStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->usage_status = $request->input('usage_status');
        $booking->save();
    
        return redirect()->back()->with('success', 'Usage status updated successfully.');
    }
    


}
