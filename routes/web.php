<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\RegisteredClientController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SosController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\ProfileCompletionController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');

require __DIR__.'/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/complete-profile', [ProfileCompletionController::class, 'showForm'])->name('profile.complete');
    Route::post('/complete-profile', [ProfileCompletionController::class, 'store'])->name('profile.store');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [ActivityController::class, 'index'])->name('dashboard');

    Route::get('/home', function () {
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

    Route::get('/booking/categories', function () {
        return view('booking.categories');
    })->name('booking.categories');

    Route::get('/booking/category/{category}', [ActivityController::class, 'showPackages'])->name('booking.category');
    Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
    Route::post('/booking-confirmation', [BookingController::class, 'showConfirmation'])->name('booking.confirmation');

    Route::get('/book-form', function (Request $request) {
        $categoryInput = $request->query('category', 'upsi');

        switch ($categoryInput) {
            case 'gov':
                $categoryTitle = 'Government Agency';
                break;
            case 'public':
                $categoryTitle = 'Public Participant';
                break;
            case 'international':
                $categoryTitle = 'International Participant';
                break;
            case 'upsi':
            default:
                $categoryTitle = 'UPSI Student / Staff';
                break;
        }

        return view('book-form', compact('categoryTitle', 'categoryInput'));
    })->name('book-form');

    Route::get('/my-bookings', function () {
        return view('my-bookings');
    })->name('my-bookings');

    Route::get('/emergency', function () {
        return view('emergency');
    })->name('emergency');

    Route::post('/emergency/sos', [SosController::class, 'sendAlert'])->name('emergency.sos');

    Route::get('/activities-list', [ActivityController::class, 'listAll'])->name('activities.list');
    Route::get('/activity/{id}', [ActivityController::class, 'showDetail'])->name('activity.detail');

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
    })->name('profile.show');

    Route::get('/profile/edit', function () {
        $profile = DB::table('profiles')->where('id', Auth::id())->first();
        return view('profile-edit', compact('profile'));
    })->name('profile.edit');

    Route::put('/profile/update', function (Request $request) {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'user_category' => 'required|string',
            'origin'        => 'required|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $profile = DB::table('profiles')->where('id', Auth::id())->first();
        $imageUrl = $profile->profile_image_url ?? null;

        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileContent = file_get_contents($file->getRealPath());
            $mimeType = $file->getClientMimeType();
            $fileName = 'user_' . Auth::id() . '_' . time() . '.' . $file->getClientOriginalExtension();

            $supabaseUrl = env('SUPABASE_URL');
            $supabaseKey = env('SUPABASE_KEY');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type'  => $mimeType,
            ])->withBody($fileContent, $mimeType)
        ->post($supabaseUrl . '/storage/v1/object/profile-images/' . $fileName);

            if ($response->successful()) {
                $imageUrl = $supabaseUrl . '/storage/v1/object/public/profile-images/' . $fileName;
            }
        }

        DB::table('profiles')
            ->where('id', Auth::id())
            ->update([
                'full_name'         => $request->full_name,
                'phone_number'      => $request->phone_number,
                'user_category'     => $request->user_category,
                'origin'            => $request->origin,
                'profile_image_url' => $imageUrl,
                'updated_at'        => now(),
            ]);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    })->name('profile.update');
});

Route::get('/admin/slots', [SlotController::class, 'index'])->name('admin.slots.index');
Route::post('/admin/slots', [SlotController::class, 'store'])->name('admin.slots.store');
Route::delete('/admin/slots/{id}', [SlotController::class, 'destroy'])->name('admin.slots.destroy');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/registered-clients', [RegisteredClientController::class, 'index'])->name('clients');

    Route::get('/booking-requests', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/booking-requests/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{booking}/verify', [AdminPaymentController::class, 'verifyPayment'])->name('payments.verify');
});