<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Driver;
use App\Mail\BookingReceiptMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingCancelledMail;
use App\Models\GpsData;
use Illuminate\Support\Facades\Http;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as PHPMailerException;


class BookingController extends Controller
{
    public function store(Request $request)
    {
        $client = Auth::user();
        if ($client->status !== 'verified') {
            return redirect()->route('welcome')->with('error', 'Your account is not yet verified. Please wait to verify your account before proceeding to booking.');
        }

        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'pickup_location' => 'required|string',
            'pickup_date' => 'required|date',
            'pickup_time' => 'required',
            'dropoff_location' => 'required|string',
            'dropoff_date' => 'required|date',
            'dropoff_time' => 'required',
            'driver_option' => 'required|string',
            'company_name' => 'required|string',
            'car_name' => 'required|string',
            'car_type' => 'required|string',
            'driver_id' => 'nullable|exists:drivers,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $car = Car::findOrFail($request->car_id);
        $driver_id = $request->driver_id;

        $pickup_datetime = \Carbon\Carbon::parse($request->pickup_date . ' ' . $request->pickup_time);
        $dropoff_datetime = \Carbon\Carbon::parse($request->dropoff_date . ' ' . $request->dropoff_time);

        $num_days = ceil($pickup_datetime->floatDiffInHours($dropoff_datetime) / 24);
        $car_amount = $num_days * $car->price_per_day;
        $driver_fee = ($request->driver_option === 'With Driver' && $driver_id) ? ($num_days * 500) : 0;
        $total_amount = $car_amount + $driver_fee;

        $booking = Booking::create([
            'car_id' => $request->car_id,
            'client_id' => Auth::id(),
            'pickup_location' => $request->pickup_location,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => $request->pickup_time ?? null,
            'dropoff_location' => $request->dropoff_location,
            'dropoff_date' => $request->dropoff_date,
            'dropoff_time' => $request->dropoff_time ?? null,
            'amount' => $total_amount,
            'status' => 'partially paid',
            'company_name' => $request->company_name,
            'car_name' => $request->car_name,
            'car_type' => $request->car_type,
            'driver_option' => $request->driver_option,
            'driver_id' => $driver_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'usage_status' => 'Not Yet Started',
        ]);

        GpsData::create([
            'car_id' => $booking->car_id,
            'client_id' => $booking->client_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);


        if ($request->driver_option === 'With Driver' && $driver_id) {
            $driver = Driver::find($driver_id);
            if ($driver) {
                \App\Models\DriverBooking::create([
                    'booking_id' => $booking->id,
                    'driver_id' => $driver->id,
                    'partner_id' => $driver->partner_id,
                    'num_days' => $num_days,
                    'total_driver_fee' => $driver_fee,
                    'status' => 'pending',
                ]);
            }
        }


        session([
            'booking' => [
                'car_id' => $car->id,
                'pickup_location' => $request->pickup_location,
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $request->pickup_time,
                'dropoff_location' => $request->dropoff_location,
                'dropoff_date' => $request->dropoff_date,
                'dropoff_time' => $request->dropoff_time,
                'driver_option' => $request->driver_option,
                'num_days' => $num_days,
                'price_per_day' => $car->price_per_day,
                'total_amount' => $total_amount,
                'company_name' => $request->company_name,
                'car_name' => $request->car_name,
                'car_type' => $request->car_type,
                'driver_id' => $driver_id,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'booking_id' => $booking->id,
            ]
        ]);

        return redirect()->route('review.payment');
    }





    public function reviewPayment()
    {
        $client = auth()->user();
        $bookingSession = session('booking', []);

        if (empty($bookingSession)) {
            return redirect()->route('welcome')->with('error', 'No booking found.');
        }

        $booking = Booking::where('client_id', Auth::id())
            ->latest()
            ->first();

        if (!$booking) {
            return redirect()->route('welcome')->with('error', 'Booking not found.');
        }

        $car = $booking->car;
        $payment = session('payment_details', []);


        Mail::to($client->email)->send(new BookingReceiptMail($booking));

        return view('review-payment', compact('client', 'booking', 'car', 'payment'));
    }




    public function showBooking($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('welcome')->with('error', 'Booking not found.');
        }

        $client = $booking->client;
        $car = $booking->car;

        return view('review-payment', compact('client', 'car', 'booking'));
    }
    public function index()
    {
        $bookings = Booking::where('client_id', Auth::id())->get()->map(function ($booking) {
            if ($booking->status === 'Done' && $booking->payment_status === 'Not Paid') {
                $booking->status = 'Partially Paid';
            }
            return $booking;
        });

        return view('my-bookings', compact('bookings'));
    }

    public function showBookingPage($carId)
    {
        $car = Car::findOrFail($carId);
        $partnerId = $car->partner_id;


        $drivers = Driver::where('partner_id', $partnerId)->get();

        return view('booking', compact('car', 'drivers'));
    }
    public function show(Car $car)
    {

        $drivers = Driver::where('partner_id', $car->partner_id)->get();

        return view('booking', compact('car', 'drivers'));

    }


    public function updateGps(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'client_id' => 'required|exists:clients,id',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        GpsData::create([
            'car_id' => $request->car_id,
            'client_id' => $request->client_id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json(['message' => 'GPS location saved successfully']);
    }

    public function cancelBookingWithPayment($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'cancelled') {
            return redirect()->route('my-bookings')->with('error', 'This booking has already been cancelled.');
        }


        if (now()->diffInHours($booking->created_at) > 24) {
            return redirect()->route('my-bookings')->with('error', 'Cancellation is only allowed within 24 hours of booking.');
        }

        $secretKey = env('PAYMONGO_SECRET_KEY');
        $amount = 150000;


        session(['cancel_booking_id' => $id]);

        $response = Http::withHeaders([
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'Basic ' . base64_encode($secretKey . ':')
        ])->post('https://api.paymongo.com/v1/checkout_sessions', [
                    'data' => [
                        'attributes' => [
                            'description' => 'Booking Cancellation Fee',
                            'line_items' => [
                                [
                                    'currency' => 'PHP',
                                    'amount' => $amount,
                                    'name' => 'Cancellation Fee',
                                    'quantity' => 1
                                ]
                            ],
                            'payment_method_types' => ['gcash'],
                            'send_email_receipt' => false,
                            'show_description' => true,
                            'reference_number' => 'CANCEL-' . time(),
                            'success_url' => route('booking.cancel.payment.success') . '?status=paid',
                            'cancel_url' => route('my-bookings')
                        ]
                    ]
                ]);

        $checkoutData = $response->json();

        if ($response->failed()) {
            return back()->with('error', 'Failed to initiate payment.');
        }

        return redirect($checkoutData['data']['attributes']['checkout_url']);
    }

    public function cancelBooking($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'cancelled') {
            return redirect()->route('my-bookings')->with('error', 'This booking has already been cancelled.');
        }

        $minutesSinceBooking = now()->diffInMinutes($booking->created_at);
        $hoursSinceBooking = now()->diffInHours($booking->created_at);

        if ($minutesSinceBooking <= 60) {
            // Free cancellation
            $booking->status = 'cancelled';
            $booking->save();

            $this->sendFreeCancellationEmail($booking);

            return redirect()->route('my-bookings')->with('success', 'Booking cancelled without fee. A confirmation email has been sent.');
        } elseif ($hoursSinceBooking <= 24) {
            // Paid cancellation
            $secretKey = env('PAYMONGO_SECRET_KEY');
            $amount = 150000; // 1500 PHP in centavos

            session(['cancel_booking_id' => $id]);

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json',
                'authorization' => 'Basic ' . base64_encode($secretKey . ':')
            ])->post('https://api.paymongo.com/v1/checkout_sessions', [
                        'data' => [
                            'attributes' => [
                                'description' => 'Booking Cancellation Fee',
                                'line_items' => [
                                    [
                                        'currency' => 'PHP',
                                        'amount' => $amount,
                                        'name' => 'Cancellation Fee',
                                        'quantity' => 1
                                    ]
                                ],
                                'payment_method_types' => ['gcash'],
                                'send_email_receipt' => false,
                                'show_description' => true,
                                'reference_number' => 'CANCEL-' . time(),
                                'success_url' => route('booking.cancel.payment.success') . '?status=paid',
                                'cancel_url' => route('my-bookings')
                            ]
                        ]
                    ]);

            if ($response->failed()) {
                return back()->with('error', 'Failed to initiate payment.');
            }

            $checkoutData = $response->json();

            return redirect($checkoutData['data']['attributes']['checkout_url']);
        } else {
            // After 24 hours
            return redirect()->route('my-bookings')->with('error', 'Cancellation is only allowed within 24 hours of booking.');
        }
    }

    public function handleCancelPaymentSuccess(Request $request)
    {
        $paymentStatus = $request->query('status');
        $bookingId = session('cancel_booking_id');

        if ($paymentStatus == 'paid' && $bookingId) {
            $booking = Booking::find($bookingId);

            if ($booking && $booking->status !== 'cancelled') {
                $booking->status = 'cancelled';
                $booking->save();

                // Send email
                $this->sendCancellationEmail($booking);

                session()->forget('cancel_booking_id');

                return redirect()->route('my-bookings')
                    ->with('success', 'Booking successfully cancelled. ₱1500 cancellation fee paid. A confirmation email has been sent.')
                    ->with('cancelled_booking', $booking); // for mock receipt
            }
        }

        return redirect()->route('my-bookings')->with('error', 'Payment failed or invalid booking.');
    }

    public function cancelBookingFree($id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->status === 'cancelled') {
            return redirect()->route('my-bookings')->with('error', 'This booking has already been cancelled.');
        }

        if (now()->diffInMinutes($booking->created_at) > 60) {
            return redirect()->route('my-bookings')->with('error', 'Free cancellation is only allowed within 1 hour.');
        }

        $booking->status = 'cancelled';
        $booking->save();

        return redirect()->route('my-bookings')->with('success', 'Booking has been cancelled without a fee.');
    }


    private function sendCancellationEmail($booking)
    {
        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arkilacarrental123@gmail.com';
            $mail->Password = 'ahchxwiujsbmdsye';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;


            $mail->setFrom('no-reply@arkila.com', 'ARKILA Car Rental');
            $mail->addAddress($booking->client->email, $booking->client->firstname);


            $mail->isHTML(true);
            $mail->Subject = 'Your Booking Has Been Cancelled';
            $mail->Body = view('emails.booking_cancelled', ['booking' => $booking])->render();

            $mail->send();
        } catch (Exception $e) {

            return back()->with('error', 'There was an error sending the email. Please try again later.');
        }
    }


    public function showCancelledBookings()
    {
        $clientId = auth()->guard('client')->id();

        $cancelledBookings = Booking::where('client_id', $clientId)
            ->where('status', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.cancelled-bookings', compact('cancelledBookings'));
    }

    public function myBookings()
    {
        $clientId = auth()->guard('client')->id();

        $bookings = Booking::where('client_id', $clientId)
            ->where('status', '!=', 'cancelled')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.my-bookings', compact('bookings'));
    }



    private function sendFreeCancellationEmail($booking)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arkilacarrental123@gmail.com';
            $mail->Password = 'ahchxwiujsbmdsye';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('no-reply@arkila.com', 'ARKILA Car Rental');
            $mail->addAddress($booking->client->email, $booking->client->firstname);

            $mail->isHTML(true);
            $mail->Subject = 'Your Booking Has Been Cancelled & Refunded';
            $mail->Body = view('emails.booking_free_cancelled', ['booking' => $booking])->render();

            $mail->send();
        } catch (Exception $e) {
            return back()->with('error', 'There was an error sending the email. Please try again later.');
        }
    }








}
