<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }


    public function sendResetLink(Request $request)
    {
        Log::info('Forgot Password Request Received for Email: ' . $request->email);
        $request->validate([
            'email' => 'required|email|exists:clients,email'
        ]);

        // Generate a password reset token
        $token = Str::random(60); // Generate a raw token

        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now(),
            ]
        );


        // Generate reset link
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);


        // Create and send the email with PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $mail->addAddress($request->email);

            $resetLink = route('password.reset', ['token' => $token]);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = 'Click the link below to reset your password:<br><a href="' . $resetLink . '">' . $resetLink . '</a>';

            if ($mail->send()) {
                Log::info('Password reset email sent successfully to ' . $request->email);
                return back()->with('status', 'Password reset link sent!');
            } else {
                Log::error('Email failed: ' . $mail->ErrorInfo);
                return back()->withErrors(['email' => 'Email could not be sent.']);
            }
        } catch (Exception $e) {
            Log::error("Email could not be sent. Error: " . $mail->ErrorInfo);
            return back()->withErrors(['email' => 'Failed to send email.']);
        }
    }

    public function showResetForm($token)
    {
        // Remove the email from the query string
        // You already have the token, and the email is fetched from the database
        $email = DB::table('password_resets')
            ->where('token', $token)
            ->value('email'); // Get the email from the password_resets table

        if (!$email) {
            // Token is invalid or expired
            return redirect()->route('forgot.password')->withErrors(['email' => 'Invalid or expired token.']);
        }

        // Pass both token and email to the reset password view
        return view('auth.reset-password', compact('token', 'email'));
    }



    public function resetPassword(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email|exists:clients,email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        // Retrieve stored reset token
        $tokenData = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$tokenData) {
            return back()->withErrors(['email' => 'Invalid token or email.']);
        }

        // Check if token has expired (valid for 60 minutes)
        if (Carbon::parse($tokenData->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Password reset link has expired.']);
        }

        // Verify the token (hashed check)
        if ($request->token !== $tokenData->token) {
            return back()->withErrors(['email' => 'Invalid token.']);
        }

        // Update password
        $client = Client::where('email', $request->email)->first();
        if ($client) {
            // Hash new password
            $hashedPassword = Hash::make($request->password);

            // Log new hashed password for debugging (remove in production)
            Log::info('New password hash: ' . $hashedPassword);

            // Save new password
            $client->password = $hashedPassword;

            // Check if save was successful
            if ($client->save()) {
                Log::info('Saving new password for user: ' . $client->email);

                // Delete reset token after successful reset
                DB::table('password_resets')->where('email', $request->email)->delete();

                return redirect()->route('login')->with('status', 'Your password has been reset. You can now log in.');
            } else {
                return back()->withErrors(['email' => 'Failed to update password.']);
            }
        }

        return back()->withErrors(['email' => 'Something went wrong. Please try again.']);
    }


}
