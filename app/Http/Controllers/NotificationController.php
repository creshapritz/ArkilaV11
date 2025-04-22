<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

class NotificationController extends Controller
{
    
    public function index()
    {
        
        $admin = Auth::guard('admin')->user();

       
        $unreadNotifications = $admin->unreadNotifications;

       
        return view('admin.notifications.index', compact('unreadNotifications'));
    }

    
    public function show($id)
    {
       
        $notification = Auth::guard('admin')->user()->notifications()->findOrFail($id);
        $notification->markAsRead();
    
        
        return view('admin.notifications.show', compact('notification'));


    }
    
   
    public function markAllAsRead()
    {
      
        $admin = Auth::guard('admin')->user();

      
        $admin->unreadNotifications->markAsRead();

      
        return redirect()->route('admin.notifications.index')->with('status', 'All notifications marked as read');
    }

    
    public function destroy($id)
    {
     
        $notification = Auth::guard('admin')->user()->notifications()->findOrFail($id);

        
        $notification->delete();

        
        return redirect()->route('admin.notifications.index')->with('status', 'Notification deleted successfully');
    }
}
