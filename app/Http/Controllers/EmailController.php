<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);
    
        try {
            $mail = new PHPMailer(true);
    
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'arkilacarrental123@gmail.com'; // Your authenticated email
            $mail->Password = 'ahchxwiujsbmdsye'; // Your email app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Recipients
            $clientName = $request->input('first-name') . ' ' . $request->input('last-name');
            $clientEmail = $request->email;
    
            // Send email from your authenticated email, but set the client's email in Reply-To
            $mail->setFrom('arkilacarrental123@gmail.com', 'ARKILA Client Inquiry'); // Authenticated email
            $mail->addAddress('arkilacarrental123@gmail.com'); // Admin email
            $mail->addReplyTo($clientEmail, $clientName); // Client email in Reply-To
    
            // Content
            $mail->isHTML(true);
            $mail->Subject = $request->input('subject');
            $mail->Body = "
                <p><strong>From:</strong> {$clientName} ({$clientEmail})</p>
                <p><strong>Subject:</strong> {$request->input('subject')}</p>
                <p><strong>Message:</strong></p>
                <p>" . nl2br(htmlspecialchars($request->input('message'))) . "</p>
            ";
    
            $mail->send();
    
            return redirect()->back()->with('success', 'Your inquiry has been sent successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Email could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }
    }
    
    
    
}
