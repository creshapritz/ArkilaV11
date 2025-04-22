<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Client;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use App\Models\Booking;
class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }


    public function login(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);


        $client = Client::where('email', $request->email)->first();

        if ($client) {

            if ($client->status === 'blocked') {
                return redirect()->back()->with('error', 'Your account has been blocked. Please contact support.');
            }


            Log::info(json_encode([
                'Entered Password' => $request->password,
                'Stored Hashed Password' => $client->password,
                'Password Match' => Hash::check($request->password, $client->password),
            ]));

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $client = Auth::user();


                $verificationCode = mt_rand(100000, 999999);
                Session::put('verification_code', $verificationCode);
                Session::put('verification_code_expiry', now()->addMinutes(10));

                Log::info('Verification code stored in session: ' . $verificationCode);


                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = env('MAIL_USERNAME');
                    $mail->Password = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;


                    $mail->setFrom('arkilacarrental123@gmail.com', 'ARKILA');
                    $mail->addAddress($client->email);


                    $emailBody = View::make('emails.verification', [
                        'first_name' => $client->first_name,
                        'verificationCode' => $verificationCode
                    ])->render();


                    $mail->isHTML(true);
                    $mail->Subject = 'Your Verification Code';
                    $mail->Body = $emailBody;


                    $mail->send();


                    return redirect()->route('loginverify')->with('success', 'Verification code sent to your email!')->with('client_name', $client->first_name);
                } catch (Exception $e) {
                    Log::error("PHPMailer Error: {$mail->ErrorInfo}");
                    return redirect()->back()->with('error', 'Failed to send verification email. Please try again.');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid email or password.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid email or password.');
        }
    }



    public function showLoginVerificationForm()
    {
        return view('loginverify');
    }


    public function verifyCode(Request $request)
    {
        Log::info('Request data:', $request->all());

        $request->validate([
            'code' => 'required|array|min:6|max:6',
            'code.*' => 'required|string|max:1'
        ]);

        $enteredCodeArray = $request->input('code', []);

        if (empty($enteredCodeArray) || count($enteredCodeArray) !== 6) {
            return redirect()->back()->with('error', 'Please enter all 6 code digits.');
        }

        $enteredCode = implode('', array_map('trim', $enteredCodeArray));

        Log::info('Final entered code:', ['enteredCode' => $enteredCode]);

        $sessionCode = Session::get('verification_code');
        $sessionExpiry = Session::get('verification_code_expiry');

        if (!$sessionCode || !$sessionExpiry || now()->gt($sessionExpiry)) {
            return redirect()->back()->with('error', 'Verification code expired. Please request a new one.');
        }

        if ((string) $enteredCode === (string) $sessionCode) {
            Session::forget('verification_code');
            Session::forget('verification_code_expiry');
            return redirect()->route('welcome')->with('success', 'Verification successful!');
        }

        return redirect()->back()->with('error', 'Invalid verification code. Please try again.');
    }






    public function resendCode()
    {
        $verificationCode = mt_rand(100000, 999999);
        Session::put('verification_code', $verificationCode);
        // Set expiration for verification code
        Session::put('verification_code_expiry', now()->addMinutes(10));

        $client = Auth::user();


        if ($client) {
            Session::put('client_name', $client->first_name);

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'arkilacarrental123@gmail.com';
                $mail->Password = 'ahchxwiujsbmdsye';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('arkilacarrental123@gmail.com', 'ARKILA');
                $mail->addAddress($client->email);

                $mail->isHTML(true);
                $mail->Subject = 'Your New Verification Code';
                $mail->Body = "
                Hello {$client->first_name},<br><br>
                <p>Your new verification code is: <strong>{$verificationCode}</strong></p>
                <p>Please enter this code on the verification page to complete your login process.</p>
                <p>Thank you,<br>ARKILA Team</p>
            ";

                $mail->send();
                return redirect()->back()->with('success', 'A new verification code has been sent to your email!');
            } catch (Exception $e) {
                Log::error("PHPMailer Error: {$mail->ErrorInfo}");
                return redirect()->back()->with('error', 'Failed to resend verification email. Please try again.');
            }
        } else {
            return redirect()->route('login')->with('error', 'Session expired. Please log in again.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }



}
