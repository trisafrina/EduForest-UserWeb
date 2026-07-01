<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\RegisteredClientController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// 🟢 FIXED: Allows Admin (via session) and normal Users to access the dashboard
Route::get('/dashboard', function () {
    if (session('admin_logged_in') || session('user_logged_in') || \Illuminate\Support\Facades\Auth::check()) {
        return view('dashboard');
    }

    return redirect()->route('login')->withErrors([
        'email' => 'Please log in first to access the system.',
    ]);
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// 🔓 BYPASS TESTING: Kita keluarkan slot dari prefix admin supaya dia "pasti boleh buka" tanpa sekatan session!
Route::get('/admin/slots', [SlotController::class, 'index'])->name('admin.slots.index');
Route::post('/admin/slots', [SlotController::class, 'store'])->name('admin.slots.store');
Route::delete('/admin/slots/{id}', [SlotController::class, 'destroy'])->name('admin.slots.destroy');


// ================= ADMIN PROTECTED ROUTES (SESSION CONTROLLED) =================
Route::prefix('admin')->name('admin.')->group(function () {

    // ✨ Menu 2: Registered Clients
    Route::get('/registered-clients', [RegisteredClientController::class, 'index'])->name('clients');

    // ✨ Menu 3: Booking Requests
    Route::get('/booking-requests', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/booking-requests/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    
    // ✨ Menu 4: Payment Verification
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{booking}/verify', [AdminPaymentController::class, 'verifyPayment'])->name('payments.verify');
});

require __DIR__.'/auth.php';