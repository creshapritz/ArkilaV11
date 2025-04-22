<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Setting;
use App\Models\Review;
use Illuminate\Support\Facades\Storage;

use App\Models\PrivacyLegal;
use App\Models\Faq;

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

    public function privacyLegal()
    {
        $terms = DB::table('privacylegal')->where('key', 'terms_conditions')->first();
        $privacy = DB::table('privacylegal')->where('key', 'privacy_policy')->first();

        if (!$terms) {
            DB::table('privacylegal')->insert(['key' => 'terms_conditions', 'value' => 'Default terms and conditions text here...']);
            $terms = DB::table('privacylegal')->where('key', 'terms_conditions')->first();
        }

        if (!$privacy) {
            DB::table('privacylegal')->insert(['key' => 'privacy_policy', 'value' => 'Default privacy policy text here...']);
            $privacy = DB::table('privacylegal')->where('key', 'privacy_policy')->first();
        }

        return view('admin.admin-settings-PL', [
            'terms' => $terms->value ?? '',
            'privacy' => $privacy->value ?? ''
        ]);
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
        $request->validate([
            'terms_conditions' => 'required|string',
            'privacy_policy' => 'required|string',
        ]);

        DB::table('privacylegal')->updateOrInsert(
            ['key' => 'terms_conditions'],
            ['value' => $request->terms_conditions]
        );

        DB::table('privacylegal')->updateOrInsert(
            ['key' => 'privacy_policy'],
            ['value' => $request->privacy_policy]
        );

        // Redirect back to the Privacy & Legal page with a success flash message
        return redirect()
            ->route('admin.admin-settings-PL')
            ->with('success', 'Privacy and Legal information updated successfully.');
    }


    public function updateLogo(Request $request)
    {
        $request->validate([
            'site_logo' => 'required|image|mimes:png,jpg,jpeg,svg|max:2048',
        ]);

        $file = $request->file('site_logo');
        $filename = time() . '_' . $file->getClientOriginalName();

      
        $file->move(public_path('logos'), $filename);

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
            'theme_color' => 'required|string'
        ]);

        Setting::updateOrCreate(
            ['key' => 'theme_color'],
            ['value' => $request->theme_color]
        );

        return redirect()->back()->with('success', 'Theme color updated!');
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
        return view('admin.archives', compact('archivedReviews'));
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
}