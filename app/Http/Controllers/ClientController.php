<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Models\Client;
use App\Mail\ClientVerifiedMail;

class ClientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'extension_name' => 'nullable|string|max:255',
            'age' => 'required|integer|min:18',
            'dob' => 'required|date',
            'contact_number' => 'required|string|max:15|different:emergency_contact',
            'address' => 'required|string|max:255',
            'emergency_contact' => 'required|string|max:15',
            'emergency_contact_relationship' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:clients',
            'email' => 'required|email|max:255|unique:clients',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);


        Session::put('registration_data', $request->except('password_confirmation'));


        $verificationCode = rand(100000, 999999);
        Session::put('verification_code', $verificationCode);
        Session::put('verification_code_time', now());


        Log::info('Incoming password: ' . $request->password);
        Log::info('Hashed password: ' . Hash::make($request->password));


        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arkilacarrental123@gmail.com';
            $mail->Password = 'ahchxwiujsbmdsye';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('arkilacarrental123@gmail.com', 'ARKILA');
            $mail->addAddress($request->email, $request->first_name);

            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email Address';
            $mail->Body = '
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>Email Verification - ARKILA</title>
                <style>
                    body {
                        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 20px;
                    }
                    .container {
                        max-width: 580px;
                        margin: auto;
                        background-color: #ffffff;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
                    }
                    h2 {
                        color: #F07324;
                        font-size: 28px;
                        margin-bottom: 10px;
                    }
                    p {
                        font-size: 16px;
                        color: #333;
                        line-height: 1.6;
                    }
                    .code-box {
                        background-color: #F9E6DB;
                        border-left: 6px solid #F07324;
                        padding: 20px;
                        margin: 20px 0;
                        font-size: 26px;
                        font-weight: bold;
                        letter-spacing: 2px;
                        text-align: center;
                        color: #F07324;
                    }
                    .footer {
                        font-size: 12px;
                        color: #777;
                        margin-top: 40px;
                        text-align: center;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h2>Hello, ' . htmlspecialchars($request->first_name) . '!</h2>
                    <p>Thank you for registering with <strong>ARKILA</strong>.</p>
                    <p>Please use the following verification code to complete your registration process:</p>
                    <div class="code-box">' . $verificationCode . '</div>
                    <p>If you didn\'t request this code, feel free to ignore this message.</p>
                    <div class="footer">
                        &copy; ' . date("Y") . ' ARKILA Car Rental. All rights reserved.
                    </div>
                </div>
            </body>
            </html>';


            $mail->send();

            Log::info('Verification email sent to: ' . $request->email);
        } catch (Exception $e) {
            Log::error('PHPMailer Error: ' . $mail->ErrorInfo);
            return redirect()->back()->with('error', 'Could not send verification email. Please try again later.');
        }

        return redirect()->route('register.verify')->with('success', 'Registration step 1 completed! Please verify your email.');
    }


    public function verifyCode(Request $request)
    {
        $request->validate([
            'verification_code' => 'required|integer',
        ]);

        $sessionCode = Session::get('verification_code');
        $codeTime = Session::get('verification_code_time');

        if (!$sessionCode || !$codeTime || now()->diffInMinutes($codeTime) > 15) {
            return redirect()->route('register')->with('error', 'Verification code expired. Please register again.');
        }

        if ($request->verification_code != $sessionCode) {
            return redirect()->back()->with('error', 'Invalid verification code. Please try again.');
        }

        return redirect()->route('register.complete.submit')->with('success', 'Email verified successfully!');
    }







    public function completeRegistration(Request $request)
    {
        $request->validate([
            'driver_license_type' => 'nullable|string',
            'front_license' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'back_license' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'service_type' => 'required|string|in:Self-Drive,With Driver',
            'first_id_front' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'first_id_back' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'second_id_type' => 'required|string',
            'front_second_id' => 'required_if:service_type,Self-Drive|nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'back_second_id' => 'required_if:service_type,Self-Drive|nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'driver_front_second_id' => 'required_if:service_type,With Driver|nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'driver_back_second_id' => 'required_if:service_type,With Driver|nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'proof_of_billing_type' => 'required|string',
            'proof_of_billing' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
            'driver_proof_of_billing' => 'required_if:service_type,With Driver|nullable|file|mimes:jpeg,jpg,png,pdf|max:5120',
        ]);

        $registrationData = Session::get('registration_data');
        if (!$registrationData) {
            return redirect()->route('register')->with('error', 'Session expired. Please start the registration process again.');
        }

        Log::info('Registration Data from Session: ' . json_encode($registrationData));

        try {
            // Move files to public folder and get the paths
            $frontLicensePath = $request->file('front_license')?->move(public_path('uploads/licenses'), time() . '_front_license.' . $request->file('front_license')->getClientOriginalExtension());
            $backLicensePath = $request->file('back_license')?->move(public_path('uploads/licenses'), time() . '_back_license.' . $request->file('back_license')->getClientOriginalExtension());
            $firstIdFrontPath = $request->file('first_id_front')?->move(public_path('uploads/ids'), time() . '_first_id_front.' . $request->file('first_id_front')->getClientOriginalExtension());
            $firstIdBackPath = $request->file('first_id_back')?->move(public_path('uploads/ids'), time() . '_first_id_back.' . $request->file('first_id_back')->getClientOriginalExtension());
            $frontSecondIdPath = $request->file('front_second_id')?->move(public_path('uploads/ids'), time() . '_front_second_id.' . $request->file('front_second_id')->getClientOriginalExtension());
            $backSecondIdPath = $request->file('back_second_id')?->move(public_path('uploads/ids'), time() . '_back_second_id.' . $request->file('back_second_id')->getClientOriginalExtension());
            $driverFrontSecondIdPath = $request->file('driver_front_second_id')?->move(public_path('uploads/ids'), time() . '_driver_front_second_id.' . $request->file('driver_front_second_id')->getClientOriginalExtension());
            $driverBackSecondIdPath = $request->file('driver_back_second_id')?->move(public_path('uploads/ids'), time() . '_driver_back_second_id.' . $request->file('driver_back_second_id')->getClientOriginalExtension());
            $proofOfBillingPath = $request->file('proof_of_billing')?->move(public_path('uploads/billing'), time() . '_proof_of_billing.' . $request->file('proof_of_billing')->getClientOriginalExtension());
            $driverProofOfBillingPath = $request->file('driver_proof_of_billing')?->move(public_path('uploads/billing'), time() . '_driver_proof_of_billing.' . $request->file('driver_proof_of_billing')->getClientOriginalExtension());

            // Save the client data in the database
            $client = Client::create(array_merge($registrationData, [
                'password' => $registrationData['password'],
                'driver_license_type' => $request->driver_license_type,
                'service_type' => $request->service_type,
                'front_license' => 'uploads/licenses/' . basename($frontLicensePath),
                'back_license' => 'uploads/licenses/' . basename($backLicensePath),
                'first_id_type' => $request->first_id,
                'front_first_id' => 'uploads/ids/' . basename($firstIdFrontPath),
                'back_first_id' => 'uploads/ids/' . basename($firstIdBackPath),
                'second_id_type' => $request->second_id_type,
                'front_second_id' => 'uploads/ids/' . basename($frontSecondIdPath),
                'back_second_id' => 'uploads/ids/' . basename($backSecondIdPath),
                'driver_front_second_id' => 'uploads/ids/' . basename($driverFrontSecondIdPath),
                'driver_back_second_id' => 'uploads/ids/' . basename($driverBackSecondIdPath),
                'proof_of_billing_type' => $request->proof_of_billing_type,
                'proof_of_billing' => 'uploads/billing/' . basename($proofOfBillingPath),
                'driver_proof_of_billing' => 'uploads/billing/' . basename($driverProofOfBillingPath),
                'status' => 'pending',
            ]));

            
            Session::forget('registration_data');
            Session::forget('verification_code');

            return redirect()->route('login')->with('success', 'Registration complete! Please log in.');
        } catch (Exception $e) {
            Log::error('Error occurred during registration: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }





    public function index()
    {
        $clients = Client::all(); 
        $clients = Client::whereNull('archived_at')->get();

        return view('admin.clients', compact('clients'));
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        return view('admin.client-details', compact('client'));
    }
    public function archive($id)
    {
        $client = Client::findOrFail($id);
        $client->delete(); 

        return redirect()->route('admin.clients')->with('success', 'Client archived successfully.');
    }

    public function verify($id)
    {
        $client = Client::findOrFail($id);
        $client->status = 'verified'; 
        $client->save();

        return redirect()->route('admin.clients')->with('success', 'Client verified successfully!');
    }
    public function verifyClient($id)
    {
        $client = Client::findOrFail($id);
        $client->status = 'verified';
        $client->save();

        Mail::to($client->email)->send(new ClientVerifiedMail($client));

        return redirect()->back()->with('success', 'Client verified and email sent.');
    }
    public function blockClient($id)
    {
        $client = Client::findOrFail($id);
        $client->status = 'blocked';
        $client->save();

        return redirect()->back()->with('success', 'Client has been blocked.');
    }
    public function unblockClient($id)
    {
        $client = Client::findOrFail($id);
        $client->status = 'verified'; 
        $client->save();
    
        return redirect()->back()->with('success', 'Client has been unblocked.');
    }
    



}
