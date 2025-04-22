<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Booking;
use App\Models\Car;

class ReviewController extends Controller
{
    public function submit(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',
        ]);

        $clientId = auth('client')->id();


        $hasBooking = Booking::where('client_id', $clientId)
            ->where('car_id', $request->car_id)
            ->where('status', 'completed')
            ->exists();

        if (!$hasBooking) {
            return redirect()->back()->with('error', 'You can only review cars you have completed a booking with.');
        }


        $existingReview = Review::where('client_id', $clientId)
            ->where('car_id', $request->car_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this car.');
        }


        Review::create([
            'car_id' => $request->car_id,
            'client_id' => $clientId,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }

    public function showCarDetails($carId)
    {
        $car = Car::with('reviews.client')->findOrFail($carId);
        $clientId = auth('client')->id();


        $hasCompletedBooking = Booking::where('car_id', $carId)
            ->where('client_id', $clientId)
            ->where('status', 'completed')
            ->exists();


        $hasReviewed = Review::where('car_id', $carId)
            ->where('client_id', $clientId)
            ->exists();


        $canReview = $hasCompletedBooking && !$hasReviewed;

        return view('client.car-details', compact('car', 'canReview'));
    }
    public function index()
    {
        $reviews = Review::with('client', 'car')->latest()->paginate(10); 

        return view('reviews.index', compact('reviews'));
    }


}
