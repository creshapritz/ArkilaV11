<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
        // Fetch all sessions from the database
        $sessions = DB::table('sessions')->get();

        // Debugging: Log fetched sessions
        \Log::info('Fetched sessions:', ['sessions' => $sessions]);

        // Pass sessions to the view
        return view('settings.account-activity', compact('sessions'));
    }
}
