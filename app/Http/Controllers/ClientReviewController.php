<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;



class ClientReviewController extends Controller
{
    public function store(Request $request)
    {
       
        $request->validate([
            'review' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
            'booking_id' => 'required|integer|exists:bookings,id',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        $car = $booking->car;
        $client = $booking->client;

      
        $existingReview = Review::where('booking_id', $booking->id)->first();
        if ($existingReview) {
            return response()->json(['status' => 'error', 'message' => 'You have already submitted a review for this booking.']);
        }

       
        try {
            $review = new Review();
            $review->car_id = $car->id;
            $review->client_id = $client->id;
            $review->booking_id = $booking->id; 
            $review->review = $request->review;
            $review->rating = $request->rating;
            $review->save();

            return response()->json(['status' => 'success', 'message' => 'Review submitted successfully.']);
        } catch (\Exception $e) {
            Log::error("Error submitting review: " . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => 'Something went wrong.']);
        }
    }





}
