<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Services\MailService;
class SettingsController extends Controller
{
    public function profileManagement()
    {
        return view('settings.profile-management');
    }

    public function accountActivity()
    {
        return view('settings.account-activity');
    }

    public function privacySecurity()
    {
        return view('settings.privacy-security');
    }

    public function helpFaqs()
    {
        return view('settings.help-faqs');
    }

    // -------------------profile management ------------------
    public function updateProfilePicture(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get the authenticated client
        $client = Auth::guard('client')->user();
        Log::info('Updating profile picture', ['user' => Auth::guard('client')->user()]);

        if (!$client) {
            return response()->json([
                'success' => false,
                'error' => 'User not authenticated.',
            ], 401);
        }

        try {
            // Handle file upload
            $file = $request->file('profile_picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = public_path('uploads/profile_pictures');

            $file->move($filePath, $fileName);

            // Update the profile picture URL in the database
            $client->profile_picture = '/uploads/profile_pictures/' . $fileName;
            $client->save();

            return response()->json([
                'success' => true,
                'new_picture_url' => asset('uploads/profile_pictures/' . $fileName),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // ---------------------------privacy and security------------------------------

    public function updatePassword(Request $request, MailService $mailService)
    {
        // Validate request input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        // Get authenticated client via correct guard
        $client = Auth::guard('client')->user();

        if (!$client) {
            return back()->withErrors(['error' => 'User not authenticated.']);
        }

        // Check if current password matches
        if (!Hash::check($request->current_password, $client->password)) {
            return back()->withErrors(['current_password' => 'Incorrect current password.']);
        }

        // Update password
        $client->password = Hash::make($request->new_password);
        $client->save();

        // Send notification email
        $subject = "Password Changed Successfully";
        $body = "Hi {$client->first_name},<br><br>Your password was successfully changed.<br>
             If this wasn't you, please reset your password immediately.";

        $mailSent = $mailService->sendMail($client->email, $subject, $body);

        if ($mailSent) {
            return back()->with('success', 'Password updated successfully. A notification has been sent to your email.');
        } else {
            return back()->with('success', 'Password updated successfully, but we could not send a notification email.');
        }
    }






}
