<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DriverRating;

class ClientRatingController extends Controller
{
    public function submit(Request $request)
    {
        $clientId = auth('client')->id();

        $request->validate([
            'driver_id' => 'required|exists:drivers,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        $existing = DriverRating::where('client_id', $clientId)
            ->where('driver_id', $request->driver_id)
            ->first();

        if ($existing) {
            return response()->json([
                'status' => 'error',
                'message' => 'You have already rated this driver.'
            ]);
        }

        DriverRating::create([
            'client_id' => $clientId,
            'driver_id' => $request->driver_id,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return response()->json(['status' => 'success']);
    }
}
