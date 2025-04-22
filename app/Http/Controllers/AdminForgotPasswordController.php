<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Password;
use App\Models\Admin;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AdminForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

  

public function sendResetLinkEmail(Request $request)
{
    $request->validate(['email' => 'required|email|exists:admins,email']);

  
    $token = Password::broker('admins')->createToken(Admin::where('email', $request->email)->first());

   
    $mail = new PHPMailer(true);

    try {
       
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'arkilacarrental123@gmail.com'; 
        $mail->Password = 'ahchxwiujsbmdsye';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('arkilacarrental123@gmail.com', 'ARKILA RECOVERY');
        $mail->addAddress($request->email);

        
        $mail->isHTML(true);
        $mail->Subject = 'Reset Your Password';
        $mail->Body = "Click the link to reset your password: <br>
                       <a href='" . url("admin/password/reset/{$token}") . "'>Reset Password</a>";

        $mail->send();

        return back()->with('status', 'Password reset link has been sent to your email.');
    } catch (Exception $e) {
        return back()->withErrors(['email' => "Mailer Error: {$mail->ErrorInfo}"]);
    }
}

}
