<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        $secretKey = env('PAYMONGO_SECRET_KEY');

        // Store booking details in session before redirecting
        session([
            'car_id' => $request->car_id,
            'pickup_location' => $request->pickup_location,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time,
            'dropoff_date' => $request->dropoff_date,
            'dropoff_time' => $request->dropoff_time,
            'amount' => $request->amount,
        ]);

        // Ensure minimum payment amount (PHP 20.00)
        $amount = max($request->amount * 100, 50000);

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'Basic ' . base64_encode($secretKey . ':')
        ])->post('https://api.paymongo.com/v1/checkout_sessions', [
                    'data' => [
                        'attributes' => [
                            'description' => 'Car Rental Payment',
                            'line_items' => [
                                [
                                    'currency' => 'PHP',
                                    'amount' => $amount,
                                    'name' => 'Car Rental Fee',
                                    'quantity' => 1
                                ]
                            ],
                            'payment_method_types' => ['gcash'],
                            'send_email_receipt' => false,
                            'show_description' => true,
                            'reference_number' => 'INV-' . time(),
                            'success_url' => route('payment.success') . '?status=paid',
                            'cancel_url' => route('payment.cancel')
                        ]
                    ]
                ]);

        $checkoutData = $response->json();

        if ($response->failed()) {
            return response()->json(['error' => $checkoutData], 400);
        }

        return redirect($checkoutData['data']['attributes']['checkout_url']);
    }

    public function handlePaymentSuccess(Request $request)
    {
        $paymentStatus = $request->query('status');
        $paymentReference = 'INV-' . time(); 

        if (!Auth::check()) {
            return redirect()->route('my-bookings')->with('error', 'You must be logged in.');
        }

      
        Log::info('Session Data:', session()->all());

        // Retrieve session data
        $carId = session('car_id');
        $pickupLocation = session('pickup_location');
        $pickupDate = session('pickup_date');
        $pickupTime = session('pickup_time');
        $dropoffDate = session('dropoff_date');
        $dropoffTime = session('dropoff_time');
        $amount = session('amount');

       
        if (!$carId) {
            Log::error("Booking session data is missing.");
            return redirect()->route('my-bookings')->with('error', 'Payment successful, but booking details are missing.');
        }

        if ($paymentStatus == 'paid') {
            try {
                
                $booking = Booking::create([
                    'car_id' => $carId,
                    'client_id' => Auth::id(),
                    'pickup_location' => $pickupLocation,
                    'pickup_date' => $pickupDate,
                    'pickup_time' => $pickupTime, 
                    'dropoff_date' => $dropoffDate,
                    'dropoff_time' => $dropoffTime, 
                    'amount' => $amount,
                    'payment_reference' => $paymentReference,
                    'status' => 'pending',
                ]);

                Log::info("Booking created successfully: " . ($booking->id ?? null));
            } catch (\Exception $e) {
                Log::error("Error creating booking: " . $e->getMessage());
                return redirect()->route('my-bookings')->with('error', 'Error creating booking. Please try again later.');
            }

         
            session()->forget(['car_id', 'pickup_location', 'pickup_date', 'pickup_time', 'dropoff_date', 'dropoff_time', 'amount']);

            return redirect()->route('my-bookings')->with('success', 'Payment successful! Booking confirmed.');
        }

        return redirect()->route('my-bookings')->with('error', 'Payment failed.');
    }

    public function handleWebhook(Request $request)
    {
        Log::info('PayMongo Webhook Data:', $request->all());

      
        $event = $request->input('data.attributes');

        if ($event['status'] === 'paid') {
           
            $reference = $event['reference_number'];

       
            $carId = session('car_id');
            $pickupLocation = session('pickup_location');
            $pickupDate = session('pickup_date');
            $pickupTime = session('pickup_time');
            $dropoffDate = session('dropoff_date');
            $dropoffTime = session('dropoff_time');
            $amount = session('amount');

            if ($carId) {
                try {
                    $paymentReference = $reference; 
                    $booking = Booking::create([
                        'car_id' => $carId,
                        'client_id' => Auth::id(),
                        'pickup_location' => $pickupLocation,
                        'pickup_date' => $pickupDate,
                        'pickup_time' => session('pickup_time'),
                        'dropoff_date' => $dropoffDate,
                        'dropoff_time' => session('dropoff_time'), 
                        'amount' => $amount,
                        'payment_reference' => $paymentReference,
                        'status' => 'pending',
                    ]);

                    Log::info("Booking created successfully: " . ($booking->id ?? null));
                } catch (\Exception $e) {
                    Log::error("Error creating booking: " . $e->getMessage());
                }


              
                session()->forget(['car_id', ]);

                return response()->json(['message' => 'Payment confirmed'], 200);
            } else {
                Log::error("Session data missing for webhook processing.");
            }
        }

        return response()->json(['message' => 'Payment not processed'], 400);
    }


}
