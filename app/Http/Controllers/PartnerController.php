<?php
namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Models\Booking;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{


    public function index()
    {
        $partners = Partner::all();
        return view('admin.partners.index', compact('partners'));
    }


    public function create()
    {
        return view('admin.partners.create');
    }

  public function store(Request $request)
{
    $request->validate([
        'company_owner' => 'required|string',
        'company_email' => 'required|email|unique:partners',
        'company_name' => 'required|string',
        'company_phone' => 'required|string',
        'company_logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'company_document' => 'required|mimes:pdf|max:2048',
    ]);

    try {
     
        $logoFile = $request->file('company_logo');
        $logoFilename = time() . '_' . $logoFile->getClientOriginalName();
        $logoPath = 'uploads/partners/logos/' . $logoFilename;
        $logoFile->move(public_path('uploads/partners/logos'), $logoFilename);

       
        $docFile = $request->file('company_document');
        $docFilename = time() . '_' . $docFile->getClientOriginalName();
        $docPath = 'uploads/partners/documents/' . $docFilename;
        $docFile->move(public_path('uploads/partners/documents'), $docFilename);

      
        Partner::create([
            'company_owner' => $request->company_owner,
            'company_email' => $request->company_email,
            'company_name' => $request->company_name,
            'company_phone' => $request->company_phone,
            'company_logo' => $logoPath, 
            'company_document' => $docPath,
            'status' => 'Active',
        ]);

        return redirect()->route('admin.partners.index')->with('success', 'Partner added successfully!');
    } catch (\Exception $e) {
        \Log::error('Partner creation error: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred: ' . $e->getMessage());
    }
}

    
    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.show', compact('partner'));
    }
    public function archive($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->status = 'Archived'; 
        $partner->save();

        return redirect()->route('admin.partners.index')->with('success', 'Partner archived successfully!');
    }

    public function unarchive($id)
    {
        $partner = Partner::findOrFail($id);
        $partner->status = 'Active'; 
        $partner->save();

        return redirect()->route('admin.partners.index')->with('success', 'Partner unarchived successfully!');
    }

    public function partnerBookings()
    {
        $bookings = Booking::all();

        return view('partners_admin.bookings.index', compact('bookings'));

    }
    public function toggleStatus(Partner $partner)
    {
        $partner->status = $partner->status === 'Active' ? 'Inactive' : 'Active';
        $partner->save();

        return response()->json(['status' => $partner->status]);
    }








}