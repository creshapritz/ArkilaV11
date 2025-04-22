<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\AdminNotificationController;
use App\Http\Controllers\AdminBookingController;
use App\Http\Controllers\AdminForgotPasswordController;
use App\Http\Controllers\AdminResetPasswordController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminBookingsController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\PartnerAdminController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GpsController;
use App\Http\Controllers\ClientFavoriteController;
use App\Http\Controllers\ClientFavoriteDriverController;
use App\Http\Controllers\ClientRatingController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ClientReviewController;
use App\Http\Controllers\AdminSettingsController;
use App\Http\Controllers\PartnersAdminBookingController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminReportController;
use App\Http\Controllers\PartnerVehicleController;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Booking;

use App\Models\Car;



Route::get('/landingpage', function () {
    return view('landingpage');
})->name('landingpage');

Route::get('/', function () {
    return redirect()->route('landingpage');
});

Route::get('/register', function () {
    return view('register');
})->name('register');


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/register', [ClientController::class, 'store'])->name('register.store');




// verification routes
Route::get('/register2', [VerificationController::class, 'show'])->name('register.verify');
Route::post('/register2', [VerificationController::class, 'verifyCode'])->name('verification.submit');
Route::post('/verify-code', [ClientController::class, 'verifyCode'])->name('verification.submit');



Route::get('/register3', function () {
    return view('register3');
})->name('register3');


Route::post('/register3', [ClientController::class, 'completeRegistration'])->name('register.complete.submit');


Route::post('/upload-files', [ClientController::class, 'uploadFiles'])->name('upload.files');

Route::post('/verification/resend', [VerificationController::class, 'resend'])->name('verification.resend');









Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [ClientController::class, 'login'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');


Route::get('/loginverify', function () {
    return view('loginverify');
})->name('loginverify');
Route::get('/loginverify', [LoginController::class, 'showLoginVerificationForm'])->name('loginverify');
Route::post('/loginverify', [LoginController::class, 'verifyCode'])->name('verify');
Route::post('/login/verify', [LoginController::class, 'verifyCode'])->name('verify');
Route::get('/login/resend-code', [LoginController::class, 'resendCode'])->name('verification.send');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
Route::get('/welcome', function () {
    $userId = Auth::id();
    $now = Carbon::now();

    $activeBooking = Booking::where('client_id', $userId)
        ->whereDate('pickup_date', '<=', $now->toDateString())
        ->whereDate('dropoff_date', '>=', $now->toDateString())
        ->first();

    return view('welcome', compact('activeBooking'));
})->name('welcome');



Route::get('/partner', function () {
    return view('partner');
})->name('partner');


Route::get('/about', function () {
    return view('about');
})->name('about');


Route::get('/rent', function () {
    return view('rent');
})->name('rent');

Route::get('/vehicles', function () {
    return view('vehicles');
})->name('vehicles');

Route::get('/services', function () {
    return view('services');
})->name('services');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');

Route::get('/self_drive', function () {
    return view('self_drive');
})->name('self_drive');

Route::get('/with_driver', function () {
    return view('with_driver');
})->name('with_driver');







//?////////// WITH ACCOUNT PAGE ///////////////////
Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');
Route::get('/welcome_about', function () {
    return view('welcome_about');
})->name('welcome_about');

Route::get('/welcome_vehicles', function () {
    return view('welcome_vehicles');
})->name('welcome_vehicles');

Route::get('/welcome_services', function () {
    return view('welcome_services');
})->name('welcome_services');

Route::get('/welcome_rent', function () {
    return view('welcome_rent');
})->name('welcome_rent');

Route::get('/welcome_contact', function () {
    return view('welcome_contact');
})->name('welcome_contact');

Route::get('/welcome_partner', function () {
    return view('welcome_partner');
})->name('welcome_partner');

Route::get('/welcome_settings', function () {
    return view('welcome_settings');
})->name('welcome_settings');

Route::get('/welcome_self_drive', function () {
    return view('welcome_self_drive');
})->name('welcome_self_drive');

Route::get('/welcome_with_driver', function () {
    return view('welcome_with_driver');
})->name('welcome_with_driver');

Route::post('/logout', function () {
    // Add your logout logic here
    Auth::logout();
    return redirect()->route('landingpage');
})->name('logout');




/////////////////////////SEARCH CARS////////////////////////
Route::get('/cars', [CarController::class, 'index'])->name('cars.index');
Route::post('/search-cars', [CarController::class, 'searchCars'])->name('cars.search');
Route::get('/car/{id}', [CarController::class, 'show'])->name('car.details');
Route::get('/search', [CarController::class, 'searchCars'])->name('cars.search');

Route::get('/cars/search', [CarController::class, 'searchCars'])->name('cars.search');
// In routes/web.php
Route::get('/view-deal/{car}', [CarController::class, 'showCarDetails'])->name('car.viewDeal');
/////////////////////////SEND EMAIL CONTACT US ////////////////////////
Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('send.email');

//////cancellation of booking
Route::get('/cancel-booking/pay/{id}', [BookingController::class, 'cancelBookingWithPayment'])->name('booking.cancel.pay');
Route::get('/cancel-booking/success', [BookingController::class, 'handleCancelPaymentSuccess'])->name('booking.cancel.payment.success');
Route::get('/cancelled-bookings', [BookingController::class, 'showCancelledBookings'])->name('client.cancelled.bookings');

/////////////////////////SETTINGS////////////////////////

// Settings routes
Route::prefix('settings')->group(function () {
    Route::get('/profile-management', [SettingsController::class, 'profileManagement'])->name('settings.profile-management');
    Route::get('/account-activity', [SettingsController::class, 'accountActivity'])->name('settings.account-activity');
    Route::get('/privacy-security', [SettingsController::class, 'privacySecurity'])->name('settings.privacy-security');
    Route::get('/help-faqs', [SettingsController::class, 'helpFaqs'])->name('settings.help-faqs');
});

/////////////////////////ACTIVITY LOGS////////////////////////
Route::get('/settings/account-activity', [SessionController::class, 'index'])->name('settings.account-activity');
//faqs
Route::get('/settings/help-faqs', [FaqController::class, 'index'])->name('settings.help-faqs');
/////////////////////////UPDATE PROFILE PICTURE////////////////////////
Route::post('/profile/picture/update', [SettingsController::class, 'updateProfilePicture'])
    ->name('profile.picture.update')
    ->middleware('auth:client');

Route::post('/update-password', [SettingsController::class, 'updatePassword'])->name('update-password');


///////////////////CHATBOT////////////////////////

Route::post('/chat', [ChatbotController::class, 'chat'])->name('chat');
Route::post('/chatbot', [App\Http\Controllers\ChatbotController::class, 'chat']);




// Password Reset Routes
Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.update');




//////////ADMIN SIDE//////////
// Admin Login Routes
Route::get('/adminlogin', [AdminAuthController::class, 'showLoginForm'])->name('admin.adminlogin');
Route::post('/adminlogin', [AdminAuthController::class, 'authenticate'])->name('admin.login.post');
// Admin Logout Route
Route::post('/adminlogout', [AdminAuthController::class, 'logout'])->name('admin.logout');
// Admin Dashboard Route (Requires Authentication with Admin Guard)
Route::get('/admin/dashboard', [AdminAuthController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware('auth:admin');
////////////////////////////////////////////////




// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/vehicles', [VehicleController::class, 'list'])->name('vehicles.list');
    Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/add-vehicle', [VehicleController::class, 'add'])->name('vehicles.add');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
    Route::delete('/vehicles/{id}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
    Route::get('/admin/vehicles/{id}/edit', [VehicleController::class, 'edit'])->name('admin.vehicles.edit');
    Route::get('/admin/vehicles/{id}', [VehicleController::class, 'show'])->name('admin.vehicles.show');
    Route::get('admin/dashboard', [VehicleController::class, 'index'])->name('admin.dashboard');
    Route::get('admin/filter', [VehicleController::class, 'filterCars'])->name('admin.filter-cars');
    Route::get('/admin/accounts', [AdminAuthController::class, 'index'])->name('admin.accounts');
    Route::get('/admin/accounts/{id}', [AdminAuthController::class, 'show'])->name('admin.show');
    Route::get('/admin/accounts/{id}/edit', [AdminAuthController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/accounts/{id}', [AdminAuthController::class, 'update'])->name('admin.update');
    Route::get('/admin/clients', [ClientController::class, 'index'])->name('admin.clients');
    Route::get('/admin/clients/{id}', [ClientController::class, 'show'])->name('admin.clients.show');
    Route::delete('/admin/clients/{id}/archive', [ClientController::class, 'archive'])->name('admin.clients.archive');

    Route::get('admin/create', [AdminAuthController::class, 'create'])->name('admin.create');
    Route::post('/admin/{id}/archive', [AdminAuthController::class, 'archive'])->name('admin.archive');
    Route::post('/admin/{id}/unarchive', [AdminAuthController::class, 'unarchive'])->name('admin.unarchive');

    Route::resource('admin', AdminAuthController::class);
    Route::get('/', [AdminAuthController::class, 'index'])->name('admin.index');


    Route::post('/toggle-status/{id}', [AdminAuthController::class, 'toggleStatus'])->name('admin.toggleStatus');


    Route::get('/bookings', [AdminAuthController::class, 'bookingsIndex'])->name('admin.bookings');


    Route::get('/drivers', [DriverController::class, 'index'])->name('admin.drivers.index');
    Route::patch('/drivers/{id}/toggle-status', [DriverController::class, 'toggleStatus'])->name('drivers.toggleStatus');
    Route::patch('/partners/{partner}/toggle-status', [PartnerController::class, 'toggleStatus']);



    // Notification routes
    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.read');

    // For individual notification details
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('notification.details');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('/notification/{id}', [NotificationController::class, 'destroy'])->name('notification.delete');

    Route::get('/verify-client/{client}', [ClientController::class, 'verify'])->name('admin.verifyClient');
    Route::post('/admin/verify-client/{id}', [ClientController::class, 'verifyClient'])->name('admin.verify.client');
    Route::post('/admin/clients/{id}/block', [ClientController::class, 'blockClient'])->name('admin.block.client');
    Route::post('/admin/clients/{id}/unblock', [ClientController::class, 'unblockClient'])->name('admin.unblock.client');



    /////////////////settings




});




/////admin settings rourte

//admin settings
Route::get('/admin/admin-settings', function () {
    return view('admin.admin-settings');
})->name('admin.admin-settings');

Route::put('/admin/update-account', [AdminSettingsController::class, 'updateAccount'])->name('admin.updateAccount');

// Show the password edit form
Route::get('/admin/update-password', [AdminSettingsController::class, 'editPassword'])->name('admin.password.edit');

// Handle the password update
Route::put('/admin/update-password', [AdminSettingsController::class, 'updatePassword'])->name('admin.password.update');


Route::get('/admin/admin-settings-PL', function () {
    return view('admin.admin-settings-PL');
})->name('admin.admin-settings-PL');


Route::get('/admin/settings', [AdminSettingsController::class, 'adminSettings'])->name('admin.settings');
Route::get('/admin/admin-settings-PL', [AdminSettingsController::class, 'privacyLegal'])->name('admin.admin-settings-PL');
Route::get('/admin/admin-settings-PL/edit', [AdminSettingsController::class, 'editPrivacyLegal'])->name('admin.PL-edit');
Route::post('/admin/admin-settings-PL/update', [AdminSettingsController::class, 'updatePrivacyLegal'])->name('admin.updatePrivacyLegal');



Route::get('admin/company-management', [AdminSettingsController::class, 'companyManagement'])->name('admin.companyManagement');
Route::post('/admin/update-logo', [AdminSettingsController::class, 'updateLogo'])->name('admin.updateLogo');

// Theme Color Update Route
Route::get('/admin/color-update', [AdminSettingsController::class, 'showThemeSettings'])->name('admin.color-update');
Route::post('/admin/update-theme-color', [AdminSettingsController::class, 'updateThemeColor'])->name('admin.updateThemeColor');
Route::get('admin/feedback-reviews', [AdminSettingsController::class, 'showReviews'])->name('admin.feedbackReviews');
Route::post('admin/reviews/archive/{id}', [AdminSettingsController::class, 'archiveReview'])->name('admin.archiveReview');
Route::get('/admin/archives', [AdminSettingsController::class, 'showArchivedReviews'])->name('admin.archives');
Route::post('/admin/archives/restore/{id}', [AdminSettingsController::class, 'restoreReview'])->name('admin.restoreReview');
Route::get('/admin/faq-settings', [AdminSettingsController::class, 'showFaqs'])->name('admin.faqs.index');
Route::put('/admin/faqs', [AdminSettingsController::class, 'updateFaqs'])->name('admin.faqs.update');
// update about us
Route::prefix('admin/settings')->middleware('auth:admin')->group(function () {
    Route::get('admin/about-us-settings', [AdminSettingsController::class, 'about'])->name('admin.about-us-settings');
    Route::post('admin/about', [AdminSettingsController::class, 'updateAbout'])->name('admin.about.update');
});
Route::prefix('admin/settings')->group(function () {
    Route::get('admin/admin-company-name', [AdminSettingsController::class, 'showCompanyName'])->name('admin.admin-company-name');
    Route::post('admin/admin-company-name', [AdminSettingsController::class, 'updateCompanyName'])->name('admin.update-company-name');
});
Route::get('/admin/change-downpayment', [AdminSettingsController::class, 'showFaqs'])->name('admin.faqs.index');
Route::get('/admin/change-downpayment', [AdminSettingsController::class, 'editDownpayment'])->name('admin.change-downpayment');
Route::post('/admin/change-downpayment', [AdminSettingsController::class, 'updateDownpayment'])->name('admin.change-downpayment.update');

















//under maintenance button
Route::post('/vehicles/{id}/status', [VehicleController::class, 'updateStatus'])->name('vehicles.updateStatus');
//archive button
Route::post('/vehicles/{id}/archive', [VehicleController::class, 'archive'])->name('vehicles.archive');
Route::get('/vehicles/maintenance', [VehicleController::class, 'maintenance'])->name('vehicles.maintenance');
Route::get('/vehicles/archived', [VehicleController::class, 'archived'])->name('vehicles.archived');


Route::get('/admin/bookings/{id}', [AdminBookingsController::class, 'show'])->name('admin.bookings.show');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [AdminResetPasswordController::class, 'reset'])->name('password.update');
});


Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('partners', PartnerController::class);

    Route::post('partners/{partner}/archive', [PartnerController::class, 'archive'])->name('partners.archive');
    Route::post('partners/{partner}/unarchive', [PartnerController::class, 'unarchive'])->name('partners.unarchive');


});

Route::get('/booking/{id}', function ($id) {
    $car = Car::findOrFail($id);
    return view('booking', compact('car'));
})->name('booking.form');
Route::get('/booking/{id}', [BookingController::class, 'showBookingPage'])->name('booking.form');




Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');
Route::get('/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');


Route::middleware(['auth:client'])->group(function () {
    Route::post('/submit-review', [ReviewController::class, 'submit'])->name('client.review.submit');


    Route::get('/car/{id}', [ReviewController::class, 'showCarDetails'])->name('client.car.details');
});

Route::post('/submit-review', [ClientReviewController::class, 'store'])->name('client.submit.review');




Route::get('/review-payment', [BookingController::class, 'reviewPayment'])->name('review.payment');


/////favorite drivers
Route::post('/favorite-driver/toggle', [ClientFavoriteController::class, 'toggleFavorite'])->name('favorite.toggle');
Route::get('/favorite-drivers', [ClientFavoriteController::class, 'index'])->name('favorite.index');
Route::post('/client/favorite-driver/toggle', [ClientFavoriteController::class, 'toggleFavorite'])
    ->middleware('auth:client')
    ->name('client.favorite.toggle');
Route::middleware(['auth:client'])->group(function () {
    Route::get('/client/favorite-drivers', [ClientFavoriteDriverController::class, 'index'])->name('client.favorites');
});
// Remove from favorites
Route::delete('/client/favorites/{driver}', [ClientFavoriteController::class, 'remove'])->name('client.favorites.remove');

Route::middleware('auth:client')->group(function () {
    Route::post('/client/rate/driver', [ClientRatingController::class, 'submit'])->name('client.rate.driver.submit');
});
Route::post('/client/rate-driver', [ClientRatingController::class, 'submit'])->name('client.rate.driver.submit');

Route::get('/client/driver/{id}/ratings', function ($id) {
    $ratings = \App\Models\DriverRating::where('driver_id', $id)
        ->with('client')
        ->latest()
        ->take(10)
        ->get();

    return response()->json($ratings);
});



Route::get('/payment-success', function () {
    return view('payment-success');
});
Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');

Route::get('/admin/bookings/{bookingId}/gps-tracking', [AdminBookingsController::class, 'gpsTracking'])->name('admin.bookings.gps-tracking');



Route::get('/admin/gps', function () {
    $booking = Booking::latest()->first();
    return view('admin.gps-tracking', compact('booking'));
})->name('admin.gps.latest');


Route::get('/admin/gps-monitor', [AdminBookingsController::class, 'gpsMonitor'])->name('admin.gps.monitor');
Route::get('/admin/gps/{carId}/{clientId}', [GpsController::class, 'getLatestGps'])->name('gps.client');
Route::get('/admin/gps/car/{carId}', [GpsController::class, 'getCarLocation'])->name('admin.gps.car');
Route::get('/admin/gps/latest/{carId}/{clientId}', [GpsController::class, 'getLatestGps'])->name('gps.latest');
Route::get('/admin/gps/show/{carId}/{clientId}', [GpsController::class, 'show'])->name('admin.gps.show');
Route::get('/admin/gps-data', [AdminBookingsController::class, 'gpsData'])->name('gps.data');
Route::post('/gps/update', [GpsController::class, 'update'])->name('gps.update');
Route::post('/update-gps', [BookingController::class, 'updateGps'])->name('booking.gps.update');
Route::get('/admin/gps/{carId}/{clientId}', [GpsController::class, 'getLatestGps']);


////////payment routes
Route::get('/pay', [PaymentController::class, 'createCheckoutSession'])->name('payment.pay');
Route::post('/payment-success', [PaymentController::class, 'handlePaymentSuccess'])->name('payment.success');
Route::get('/my-bookings', [BookingController::class, 'index'])->name('my-bookings');
Route::post('/paymongo-webhook', [PaymentController::class, 'handleWebhook'])->name('paymongo.webhook');
Route::get('/payment-cancel', function () {
    return redirect()->route('my-bookings')->with('error', 'Payment was cancelled.');
})->name('payment.cancel');
Route::post('/paymongo-webhook', function (Request $request) {
    Log::info('Webhook received:', $request->all());
    return response()->json(['status' => 'success']);
});
Route::get('/payment-success', function () {
    return view('payment-success');
})->name('payment.success');
Route::get('/payment-cancel', function () {
    return view('payment-cancel');
})->name('payment.cancel');
Route::get('/review-payment', [BookingController::class, 'reviewPayment'])->name('review.payment');
////driver


Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
    Route::get('/drivers/create', [DriverController::class, 'create'])->name('drivers.create');
    Route::post('/drivers/store', [DriverController::class, 'store'])->name('drivers.store');
    Route::get('/drivers/{id}', [DriverController::class, 'show'])->name('drivers.show');
    Route::delete('/drivers/{id}/archive', [DriverController::class, 'archive'])->name('drivers.archive');

});

Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings.index');




Route::get('/cancel-free-booking/{id}', [BookingController::class, 'cancelBookingFree'])->name('cancel.free.booking');
Route::get('/cancel-booking/pay/{id}', [BookingController::class, 'cancelBookingWithPayment'])->name('cancel.booking.pay');

Route::get('/cancel-paid-booking/{id}', [BookingController::class, 'cancelBookingWithPayment'])->name('booking.cancel.paid');
Route::get('/cancel-payment-success', [BookingController::class, 'handleCancelPaymentSuccess'])->name('booking.cancel.payment.success');
Route::get('/cancel-booking/{id}', [BookingController::class, 'cancelBooking'])->name('booking.cancel');
Route::get('/cancel-booking/success', [BookingController::class, 'handleCancelPaymentSuccess'])->name('booking.cancel.payment.success');

///////////////////////booking drivers

Route::get('/admin/bookings', [AdminBookingsController::class, 'index'])->name('admin.bookings');

/////////////admin reports

Route::get('/reports', [ReportController::class, 'index'])->name('admin.reports.index');
Route::prefix('reports')->name('admin.reports.')->group(function () {
    Route::get('/sales', function () {
        return view('admin.reports.sales');
    })->name('sales');

    Route::get('/bookings', function () {
        return view('admin.reports.bookings');
    })->name('bookings');

    Route::get('/clients', function () {
        return view('admin.reports.clients');
    })->name('clients');

    Route::get('/drivers', function () {
        return view('admin.reports.drivers');
    })->name('drivers');
});
Route::prefix('admin/reports')->middleware('auth:admin')->group(function () {
    Route::get('/sales', [ReportController::class, 'sales'])->name('admin.reports.sales');
    Route::get('/bookings', [ReportController::class, 'bookings'])->name('admin.reports.bookings');
    Route::get('/clients', [ReportController::class, 'clients'])->name('admin.reports.clients');
    Route::get('/drivers', [ReportController::class, 'drivers'])->name('admin.reports.drivers');
    Route::get('/cars', [ReportController::class, 'cars'])->name('admin.reports.cars');
    Route::get('/cars/export/{car_id}', [AdminReportController::class, 'exportSpecificCarPDF'])->name('admin.reports.cars.exportSpecificPDF');
    Route::get('/cars/export', [AdminReportController::class, 'exportAllCarsPDF'])->name('admin.reports.cars.exportPDF');

});
Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
Route::get('/admin/sales/export', [AdminReportController::class, 'exportPDF'])->name('admin.sales.export');
Route::get('/admin/reports/bookings/export-pdf', [AdminReportController::class, 'exportBookingsPdf'])->name('admin.reports.bookings.exportPdf');
Route::get('/admin/reports/clients/export-pdf', [AdminReportController::class, 'exportClientsPDF'])->name('admin.reports.clients.exportPDF');
Route::get('/admin/reports/clients/export-specific', [AdminReportController::class, 'exportSpecificClientPDF'])->name('admin.reports.clients.exportSpecificPDF');
Route::get('/admin/reports/arkila-earnings', [ReportController::class, 'arkilaEarnings'])->name('admin.reports.arkila_earnings');


Route::get('/admin/reports/arkila', [AdminReportController::class, 'arkilaEarningsReport'])->name('admin.reports.arkila');
Route::get('/admin/reports/arkila/export', [AdminReportController::class, 'exportArkilaReport'])->name('admin.reports.arkila.export');
Route::get('/admin/reports/sales/export', [AdminReportController::class, 'exportPDF'])->name('admin.reports.exportPDF');


Route::get('/admin/reports/drivers/export-pdf', [AdminReportController::class, 'exportDriverReportPdf'])
    ->name('admin.reports.drivers.exportPdf');



//////partners_admin


Route::prefix('partners_admin')->name('partners_admin.')->group(function () {
    Route::get('/login', [PartnerAdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [PartnerAdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [PartnerAdminController::class, 'logout'])->name('logout');

    Route::get('/drivers/create', [PartnerAdminController::class, 'createDriver'])->name('drivers.create');
    Route::post('/drivers/store', [PartnerAdminController::class, 'storeDriver'])->name('drivers.store');


    Route::middleware('auth:partner_admin')->group(function () {
        Route::get('/dashboard', [PartnerAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/filter-cars', [PartnerAdminController::class, 'filterCars'])->name('filter-cars');
        Route::get('/bookings', [PartnerController::class, 'partnerBookings'])->name('bookings');

        Route::get('/bookings', [PartnerAdminController::class, 'partnerBookings'])->name('bookings');
        Route::get('/cars/{id}', [PartnerAdminController::class, 'showCar'])->name('cars.show');

        Route::get('/filter-cars', [PartnerAdminController::class, 'dashboard'])->name('filter-cars');

        Route::get('/bookings/{id}/checklist', [PartnerAdminController::class, 'showChecklist'])->name('bookings.checklist');
        Route::post('/bookings/{id}/checklist', [PartnerAdminController::class, 'submitChecklist'])->name('bookings.submitChecklist');
        Route::get('/bookings/{id}/checklist/pdf', [PartnerAdminController::class, 'generateChecklistPDF'])->name('bookings.checklist.pdf');


        Route::put('/bookings/update-status/{id}', [PartnerAdminController::class, 'updateStatus'])->name('bookings.updateStatus');
        Route::get('/transaction-history', [PartnerAdminController::class, 'transactionHistory'])->name('transaction_history');


        Route::get('/dashboard', [PartnerAdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/clients/{id}', [PartnerAdminController::class, 'show'])->name('clients.show');

        Route::get('/clients', [PartnerAdminController::class, 'clients'])->name('clients.index');
        Route::delete('/clients/{id}', [PartnerAdminController::class, 'archive'])->name('clients.archive');

        Route::get('/cars', [PartnerAdminController::class, 'cars'])->name('cars.index');
        Route::get('/vehicles/{id}', [PartnerAdminController::class, 'show'])->name('partners_admin.cars.show');

        Route::get('/drivers', [PartnerAdminController::class, 'drivers'])->name('drivers.index');
        Route::get('/drivers/{id}', [PartnerAdminController::class, 'showDriver'])->name('drivers.show');
        Route::delete('/drivers/{id}/archive', [PartnerAdminController::class, 'archiveDriver'])->name('drivers.archive');

        Route::get('/cars', [PartnerAdminController::class, 'cars'])->name('cars.index');
        Route::get('/cars/create', [PartnerAdminController::class, 'createCar'])->name('cars.create');

        Route::put('/partners-admin/bookings/{id}/usage-status', [PartnersAdminBookingController::class, 'updateUsageStatus'])
            ->name('partners_admin.bookings.updateUsageStatus');




    });


});
Route::middleware(['auth:partner_admin'])->group(function () {
    Route::get('partners_admin/drivers', [PartnerAdminController::class, 'index'])->name('partners_admin.drivers.index'); // Update route name here


    Route::get('partners_admin/cars/create', [PartnerVehicleController::class, 'create'])->name('partners_admin.cars.create'); // Update route name here

    Route::post('partners_admin/cars/store', [PartnerVehicleController::class, 'store'])->name('cars.store'); // Update route name here
    Route::get('partners_admin/drivers/{id}', [PartnerAdminController::class, 'show'])->name('drivers.show'); // Update route name here
});



Route::get('/partner_admin/drivers', [PartnerAdminController::class, 'index'])->name('partner_admin.drivers.index');

Route::get('/partner/bookings/checklist-pdf/{id}', [PartnerAdminController::class, 'generateChecklistPdf'])
    ->name('partners_admin.bookings.checklist.pdf');

Route::middleware(['auth:partner_admin'])->group(function () {
    Route::get('/partner-admin/change-password', [PartnerAdminController::class, 'showChangePasswordForm'])->name('partner_admin.showChangePasswordForm');
    Route::post('/partner-admin/change-password', [PartnerAdminController::class, 'updatePassword'])->name('partner_admin.updatePassword');
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');

});

Route::put('/partners_admin/bookings/{id}/usage-status', [PartnersAdminBookingController::class, 'updateUsageStatus'])->name('partners_admin.bookings.updateUsageStatus');

Route::get('/partners_admin/login', [PartnerAdminController::class, 'showLoginForm'])->name('partners_admin.login');

Route::post('/partner_admin/login', [PartnerAdminController::class, 'login'])->name('partner_admin.login.submit');


use App\Http\Controllers\StaffAdminController;

Route::prefix('staff_admin')->name('staff_admin.')->group(function () {
    Route::get('/login', [StaffAdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [StaffAdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [StaffAdminController::class, 'logout'])->name('logout');
    Route::middleware('auth:staff_admin')->group(function () {
        Route::get('/dashboard', [StaffAdminController::class, 'dashboard'])->name('dashboard');
    });
});


use App\Http\Controllers\DriverAdminController;


Route::prefix('driver_admin')->name('driver_admin.')->group(function () {
    Route::get('/login', [DriverAdminController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [DriverAdminController::class, 'login'])->name('login.post');
    Route::post('/logout', [DriverAdminController::class, 'logout'])->name('logout');
    Route::middleware('auth:driver_admin')->group(function () {
        Route::get('/dashboard', [DriverAdminController::class, 'dashboard'])->name('dashboard');
    });
});


Route::prefix('admin')->group(function () {
    Route::get('/partners', [PartnerController::class, 'index'])->name('admin.partners.index');
    Route::get('/partners/create', [PartnerController::class, 'create'])->name('admin.partners.create');
    Route::post('/partners', [PartnerController::class, 'store'])->name('admin.partners.store');
});
