<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\Review;
use App\Models\Faq;
use App\Models\Backup;
use App\Models\Client;
use Illuminate\Support\Facades\Storage;

use App\Models\PrivacyLegal;

class AdminSettingsController extends Controller
{
    public function updateAccount(Request $request)
    {
        $admin = auth('admin')->user();

        $validated = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:admins,email,' . $admin->id,
            'password' => 'nullable|confirmed|min:6',
        ]);

        $admin->first_name = $validated['firstname'];
        $admin->last_name = $validated['lastname'];
        $admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return back()->with('success', 'Account updated successfully!');
    }


    public function editPassword()
    {
        return view('admin.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        if (!Hash::check($request->current_password, auth('admin')->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match']);
        }

        $admin = auth('admin')->user();
        $admin->password = Hash::make($request->password);
        $admin->save();

        return redirect()->route('admin.admin-settings')->with('success', 'Password updated successfully.');
    }


    public function showPrivacyLegal()
    {
        $privacyLegal = PrivacyLegal::first();

        $terms = asset($privacyLegal->terms_conditions);
        $privacy = asset($privacyLegal->privacy_policy);

        return view('admin.admin-settings-PL', compact('terms', 'privacy'));
    }

    public function editPrivacyLegal()
    {
        $terms = PrivacyLegal::where('key', 'terms_conditions')->value('value');
        $privacy = PrivacyLegal::where('key', 'privacy_policy')->value('value');

        return view('admin.PL-edit', compact('terms', 'privacy'));
    }

    public function adminSettings()
    {
        $terms = DB::table('privacylegal')->where('key', 'terms_conditions')->value('value');
        $privacy = DB::table('privacylegal')->where('key', 'privacy_policy')->value('value');

        return view('admin.admin-settings', compact('terms', 'privacy'));
    }

    public function updatePrivacyLegal(Request $request)
    {
        if ($request->hasFile('terms_conditions')) {
            $filename = 'terms_conditions_' . time() . '.' . $request->file('terms_conditions')->getClientOriginalExtension();
            $path = $request->file('terms_conditions')->move(public_path('documents'), $filename);

            PrivacyLegal::updateOrCreate(
                ['key' => 'terms_conditions'],
                ['value' => 'documents/' . $filename]
            );
        }

        if ($request->hasFile('privacy_policy')) {
            $filename = 'privacy_policy_' . time() . '.' . $request->file('privacy_policy')->getClientOriginalExtension();
            $path = $request->file('privacy_policy')->move(public_path('documents'), $filename);

            PrivacyLegal::updateOrCreate(
                ['key' => 'privacy_policy'],
                ['value' => 'documents/' . $filename]
            );
        }

        return back()->with('success', 'Privacy & Legal documents updated successfully!');
    }



    public function updateLogo(Request $request)
    {
        $request->validate([
            'site_logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $file = $request->file('site_logo');
        $filename = time() . '_' . $file->getClientOriginalName();

        // Move to public/logos
        $file->move(public_path('logos'), $filename);

        // Save relative path
        $path = 'logos/' . $filename;

        Setting::updateOrCreate(
            ['key' => 'site_logo'],
            ['value' => $path]
        );

        return back()->with('success', 'Logo updated successfully!');
    }




    public function companyManagement()
    {
        $currentLogo = DB::table('settings')->where('key', 'site_logo')->value('value');
        return view('admin.company-management', compact('currentLogo'));
    }


    public function showThemeSettings()
    {
        // Fetch theme color from settings table
        $themeColor = DB::table('settings')->where('key', 'theme_color')->value('value') ?? '#3b82f6'; // default color

        return view('admin.color-update', compact('themeColor')); // Adjust the view name accordingly
    }

    public function updateThemeColor(Request $request)
    {
        $request->validate([
            'theme_color' => 'required|string',
            'secondary_color' => 'required|string',
        ]);

        Setting::updateOrCreate(['key' => 'theme_color'], ['value' => $request->theme_color]);
        Setting::updateOrCreate(['key' => 'secondary_color'], ['value' => $request->secondary_color]);

        return back()->with('success', 'Theme colors updated successfully.');
    }

    public function archiveClient($id)
    {
        $client = Client::findOrFail($id);
        $client->is_archived = true; // Set to true (1)
        $client->archived_at = now(); // Set the timestamp to the current time
        $client->save();


        return redirect()->back()->with('success', 'Client archived successfully.');
    }

    public function restoreClient($id)
    {
        $client = Client::findOrFail($id);
        $client->is_archived = false;
        $client->save();

        return redirect()->back()->with('success', 'Client restored successfully.');
    }

    public function deleteClientFromArchive($id)
    {
        $client = Client::where('is_archived', true)->findOrFail($id);

        // Backup the client data before deleting
        Backup::create([
            'type' => 'client',
            'data' => $client->toArray(),
        ]);

        $client->delete();

        return back()->with('success', 'Client has been permanently deleted and backed up.');
    }




    public function showReviews()
    {
        $reviews = Review::with(['client', 'car']) // assuming you have relationships
            ->where('is_archived', false)
            ->get();

        return view('admin.feedback-reviews', compact('reviews'));
    }

    public function archiveReview($id)
    {
        $review = Review::findOrFail($id);
        $review->is_archived = true;
        $review->save();

        return redirect()->back()->with('success', 'Review archived successfully.');
    }

    public function showArchivedReviews()
    {
        $archivedReviews = Review::where('is_archived', true)->get();
        $archivedClients = Client::where('is_archived', true)->get();
        return view('admin.archives', compact('archivedReviews', 'archivedClients'));
    }

    public function restoreReview($id)
    {
        $review = Review::findOrFail($id);
        $review->is_archived = false;
        $review->save();

        return redirect()->back()->with('success', 'Review restored successfully!');
    }



    public function showFaqs()
    {
        $faqs = Faq::all(); // fetch all FAQs
        return view('admin.faqs-settings', compact('faqs')); // make sure this path matches your Blade file
    }

    public function updateFaqs(Request $request)
    {
        $data = $request->input('faqs', []);

        foreach ($data as $id => $faqData) {
            Faq::where('id', $id)->update([
                'question' => $faqData['question'],
                'answer' => $faqData['answer'],
            ]);
        }

        return redirect()->back()->with('success', 'FAQs updated successfully!');
    }


    public function about()
    {
        $aboutUs = Setting::where('key', 'about_us')->value('value');
        return view('admin.about-us-settings', compact('aboutUs'));
    }

    public function updateAbout(Request $request)
    {
        $request->validate([
            'about_us' => 'required|string',
        ]);

        Setting::updateOrCreate(
            ['key' => 'about_us'],
            ['value' => $request->input('about_us')]
        );

        return back()->with('success', 'About Us content updated successfully!');
    }


    public function showCompanyName()
    {
        $companyName = Setting::where('key', 'company_name')->value('value');
        return view('admin.admin-company-name', compact('companyName'));
    }

    public function updateCompanyName(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
        ]);

        Setting::updateOrCreate(
            ['key' => 'company_name'],
            ['value' => $request->company_name]
        );

        return back()->with('success', 'Company name updated successfully!');
    }


    public function editDownpayment()
    {
        $percentage = Setting::where('key', 'downpayment_percentage')->value('value');
        return view('admin.change-downpayment', compact('percentage'));
    }

    public function updateDownpayment(Request $request)
    {
        $request->validate([
            'percentage' => 'required|numeric|min:1|max:100'
        ]);

        Setting::updateOrCreate(
            ['key' => 'downpayment_percentage'],
            ['value' => $request->percentage]
        );

        return redirect()->back()->with('success', 'Downpayment percentage updated successfully!');
    }


    public function mediaSettings()
    {
        $videoPath = Setting::where('key', 'welcome_video')->value('value');
        $bannerPath = Setting::where('key', 'ads_banner')->value('value');

        return view('admin.media-settings', compact('videoPath', 'bannerPath'));
    }





    public function updateMedia(Request $request)
    {
        if ($request->hasFile('welcome_video')) {
            $videoFile = $request->file('welcome_video');
            $videoName = 'welcome_video.' . $videoFile->getClientOriginalExtension();
            $videoFile->move(public_path('assets/img'), $videoName);

            Setting::updateOrCreate(
                ['key' => 'welcome_video'],
                ['value' => 'assets/img/' . $videoName]
            );
        }

        if ($request->hasFile('ads_banner')) {
            $bannerFile = $request->file('ads_banner');
            $bannerName = 'ads_banner.' . $bannerFile->getClientOriginalExtension();
            $bannerFile->move(public_path('assets/img'), $bannerName);

            Setting::updateOrCreate(
                ['key' => 'ads_banner'],
                ['value' => 'assets/img/' . $bannerName]
            );
        }

        if ($request->hasFile('footer_video')) {
            $footervideo = $request->file('footer_video');
            $footerVideoName = 'footer_video.' . $footervideo->getClientOriginalExtension();
            $footervideo->move(public_path('assets/img'), $footerVideoName);

            Setting::updateOrCreate(
                ['key' => 'footer_video'],
                ['value' => 'assets/img/' . $footerVideoName]
            );
        }

        return back()->with('success', 'Media updated successfully.');
    }

    public function deleteReviewFromArchive($id)
    {
        $review = Review::where('id', $id)->where('is_archived', true)->firstOrFail();

        Backup::create([
            'type' => 'review',
            'data' => $review->toArray(),
        ]);

        $review->delete();

        return back()->with('success', 'Archived item has been moved to backup.');
    }


    public function showBackups()
    {
        $backups = Backup::latest()->get();
        return view('admin.backup-restore', compact('backups'));
    }

    public function restoreFromBackup($id)
    {
        $backup = Backup::findOrFail($id);

        if ($backup->type === 'review') {
          
            $review = Review::create($backup->data);
            $review->is_archived = true;
            $review->save();
        }
        if ($backup->type === 'client') {
            $client = Client::create($backup->data);
            $client->archived_at = true;
            $client->save();
        }
       
        $backup->delete();

        return back()->with('success', 'Backup restored and review moved back to archives.');
    }


    public function deleteBackup($id)
    {
        Backup::destroy($id);

        return back()->with('success', 'Backup deleted permanently.');
    }
}