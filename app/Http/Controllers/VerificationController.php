<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class VerificationController extends Controller
{
    /**
     * Display the verification form.
     */
    public function show()
    {

        return view('register2');
    }


    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|array|size:6',
        ]);
    
        // Retrieve the stored verification code and timestamp
        $sessionCode = Session::get('verification_code');
        $codeTime = Session::get('verification_code_time');
    
        // Check if the code exists and if the time difference is within the allowed period (15 minutes)
        if (!$sessionCode || !$codeTime || now()->diffInMinutes($codeTime) > 15) {
            return redirect()->route('register.verify')->with('error', 'Verification code expired. Please request a new code.');
        }
    
        // Check if the entered verification code matches the session code
        if ($request->verification_code != $sessionCode) {
            return redirect()->route('verification.form')->with('error', 'Invalid verification code.');
        }
    
        // Code is valid, proceed to the next step
        return redirect()->route('register.complete.submit')->with('success', 'Email verified successfully!');
    }

    public function resend(Request $request)
{
    Log::info('Resend route hit!');

    // Generate a new verification code
    $verificationCode = rand(100000, 999999);
    Session::put('verification_code', $verificationCode);
    Session::put('verification_code_time', now());

    $client = Session::get('registration_data'); // Retrieve temporary registration data

    if (!$client) {
        Log::error('No client data found in session.');
        return redirect()->route('register')->with('error', 'Session expired. Please restart the registration process.');
    }

    // Send email
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
        $mail->addAddress($client['email'], $client['first_name']);

        $mail->isHTML(true);
        $mail->Subject = 'Your New Verification Code';
        $mail->Body = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; background-color: #f9f9f9; padding: 30px; border-radius: 10px; border: 1px solid #eee;'>
            <h2 style='color: #333;'>Hello {$client['first_name']}!</h2>
            <p style='font-size: 16px; color: #555;'>
                Thank you for signing up with <strong>ARKILA</strong> Car Rental. To complete your registration, please enter the verification code below on the verification page.
            </p>
            
            <div style='margin: 30px 0; text-align: center;'>
                <span style='font-size: 32px; font-weight: bold; color: #f07324; letter-spacing: 8px;'>{$verificationCode}</span>
            </div>
    
            <p style='font-size: 14px; color: #777;'>
                This code will expire in 15 minutes. If you did not request this, please ignore this email.
            </p>
    
       
    
            <p style='margin-top: 40px; font-size: 12px; color: #aaa; text-align: center;'>
                &copy; " . date('Y') . " ARKILA Car Rental. All rights reserved.
            </p>
        </div>
    ";
    

        $mail->send();
        Log::info('Verification email sent to ' . $client['email']);
        
        // Redirect back to register-2 with a success message
        return redirect()->back()->with('success', 'A new verification code has been sent to your email.');
    } catch (Exception $e) {
        Log::error("PHPMailer Error: {$mail->ErrorInfo}");
        return redirect()->back()->with('error', 'Failed to resend verification email. Please try again.');
    }
}

    


    




}
