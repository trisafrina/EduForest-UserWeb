<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SosController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileCompletionController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// 1. ROUTE PUBLIC
Route::get('/', function () { return view('welcome'); });
Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');

// 2. ROUTE AUTH ASAL (Login / Register)
require __DIR__.'/auth.php';

// 3. ROUTE ISI PROFILE (Hanya pergi sini selepas register)
Route::middleware(['auth'])->group(function () {
    Route::get('/complete-profile', [ProfileCompletionController::class, 'showForm'])->name('profile.complete');
    Route::post('/complete-profile', [ProfileCompletionController::class, 'store'])->name('profile.store');
});

// 4. ROUTE DALAM (Wajib Login Sahaja, Orang Lama & Orang Baru Dua-dua Boleh Masuk)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ActivityController::class, 'index'])->name('dashboard');
    Route::get('/home', function () {
        // 🟢 SAYA TAMBAH DISINI: Ambil tarikh fully_booked & public_holiday dari table booking_dates (Supabase)
        $fullyBookedDates = DB::table('booking_dates')
            ->where('status', 'fully_booked')
            ->pluck('booking_date')
            ->map(fn ($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
            ->values();

        $publicHolidayDates = DB::table('booking_dates')
            ->where('status', 'public_holiday')
            ->pluck('booking_date')
            ->map(fn ($d) => \Carbon\Carbon::parse($d)->format('Y-m-d'))
            ->values();

        return view('home', compact('fullyBookedDates', 'publicHolidayDates'));
    })->name('home');

    // Proses Booking
    Route::get('/booking/categories', function () { return view('booking.categories'); })->name('booking.categories');
    Route::get('/booking/category/{category}', [ActivityController::class, 'showPackages'])->name('booking.category');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking-confirmation', [BookingController::class, 'showConfirmation'])->name('booking.confirmation');
    
    // Borang Booking Form
    Route::get('/book-form', function (Illuminate\Http\Request $request) {
        $categoryInput = $request->query('category', 'upsi');
        switch ($categoryInput) {
            case 'gov': $categoryTitle = 'Government Agency'; break;
            case 'public': $categoryTitle = 'Public Participant'; break;
            case 'international': $categoryTitle = 'International Participant'; break;
            case 'upsi': default: $categoryTitle = 'UPSI Student / Staff'; break;
        }
        return view('book-form', compact('categoryTitle', 'categoryInput'));
    })->name('book-form');

    // Lain-lain
    Route::get('/my-bookings', function () { return view('my-bookings'); })->name('my-bookings');
    Route::get('/emergency', function () { return view('emergency'); })->name('emergency');
    Route::post('/emergency/sos', [SosController::class, 'sendAlert'])->name('emergency.sos');
    
    // Halaman katalog grid aktiviti khas
    Route::get('/activities-list', [ActivityController::class, 'listAll'])->name('activities.list');

    // Tambah baris baru ini tepat di bawah activities.list untuk ke halaman detail swipe gambar
    Route::get('/activity/{id}', [ActivityController::class, 'showDetail'])->name('activity.detail');
    
    // Profile Edit
    Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
    // Proses Pembayaran (Diselaraskan dengan PaymentController)
    Route::get('/payment/{reference_number}', [PaymentController::class, 'showPayment'])->name('payment.instruction');
    Route::post('/payment/{reference_number}/submit', [PaymentController::class, 'submitReceipt'])->name('payment.submit');
    Route::get('/payment/{reference_number}/status', [PaymentController::class, 'showStatus'])->name('payment.status');

    Route::get('/maps', function () {
        return view('maps');
    })->name('maps.index');

Route::get('/contact-us', function () {
    return view('contact');
})->name('contact.us');
Route::get('/help-and-support', function () {
    return view('support');
})->name('help.support');

Route::get('/notifications', function () {
    // Tarik data secara dinamik dari jadual 'notifications' di Supabase
    // Ia akan mengambil kolum 'id', 'user_id', 'title', 'message', dan 'created_at' yang diisi oleh admin
    $notifications = DB::table('notifications')
                        ->orderBy('created_at', 'desc')
                        ->get();

    return view('notifications', compact('notifications'));
})->name('notifications.index');


Route::get('/profile', function () {
    $profile = DB::table('profiles')->where('id', Auth::id())->first();

    if (!$profile) {
        return redirect()->route('profile.complete');
    }

    return view('profile', compact('profile'));
})->name('profile.show')->middleware('auth');
Route::get('/profile/edit', function () {
    $profile = DB::table('profiles')->where('id', Auth::id())->first();
    return view('profile-edit', compact('profile'));
})->name('profile.edit')->middleware('auth');

Route::put('/profile/update', function (Request $request) {
    $request->validate([
        'full_name'     => 'required|string|max:255',
        'phone_number'  => 'required|string|max:20',
        'user_category' => 'required|string',
        'origin'        => 'required|string|max:255',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maksimum 2MB
    ]);

    $profile = DB::table('profiles')->where('id', Auth::id())->first();
    $imageUrl = $profile->profile_image_url ?? null;

    // JIKA USER MUAT NAIK GAMBAR BARU - HANTAR TERUS KE BUCKET 'profile-images'
    if ($request->hasFile('profile_image')) {
        $file = $request->file('profile_image');
        
        $fileContent = file_get_contents($file->getRealPath());
        $mimeType = $file->getClientMimeType();
        
        // Cipta nama unik fail (Contoh: user_1_171829202.png)
        $fileName = 'user_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();

        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY'); 

        // 🟢 Diubah ke baldi: 'profile-images' mengikut gambar terbaru awak
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type'  => $mimeType,
        ])->withBody($fileContent, $mimeType)
        ->post($supabaseUrl . '/storage/v1/object/profile-images/' . $fileName);

        // Jika berjaya simpan di Supabase Storage, ambil Public URL dia
        if ($response->successful()) {
            $imageUrl = $supabaseUrl . '/storage/v1/object/public/profile-images/' . $fileName;
        }
    }

    // UPDATE DATA PROFIL MASUK KE DATABASE SUPABASE
    DB::table('profiles')
        ->where('id', Auth::id())
        ->update([
            'full_name'         => $request->full_name,
            'phone_number'      => $request->phone_number,
            'user_category'     => $request->user_category,
            'origin'            => $request->origin,
            'profile_image_url' => $imageUrl, // Simpan URL ke kolum profile_image_url
            'updated_at'        => now(),
        ]);

    return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
})->name('profile.update')->middleware('auth');
    
});