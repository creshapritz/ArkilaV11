<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // Fetch all FAQs from the database
        $faqs = Faq::all();

        // Pass FAQs to the view
        return view('settings.help-faqs', compact('faqs'));
    }

   
}
