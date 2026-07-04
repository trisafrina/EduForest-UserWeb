<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\RegisteredClientController;
use App\Http\Controllers\Admin\SlotController;
use App\Http\Controllers\User\ActivityController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\PackageController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileCompletionController;
use App\Http\Controllers\User\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

Route::get('/', [ActivityController::class, 'index'])->name('homepage');
// TEMPORARY DEBUG ROUTE - REMOVE AFTER TROUBLESHOOTING
Route::get('/__debug-env-check-9f3k', function () {
    $url = env('SUPABASE_URL');
    $key = env('SUPABASE_KEY');
    $serviceKey = env('SUPABASE_SERVICE_ROLE_KEY');

    return response()->json([
        'SUPABASE_URL_raw' => $url,
        'SUPABASE_URL_length' => $url ? strlen($url) : 0,
        'SUPABASE_KEY_is_set' => !empty($key),
        'SUPABASE_KEY_length' => $key ? strlen($key) : 0,
        'SUPABASE_SERVICE_ROLE_KEY_is_set' => !empty($serviceKey),
        'APP_ENV' => env('APP_ENV'),
        'APP_URL' => env('APP_URL'),
    ]);
});

Route::get('/home', function () {
    return redirect()->route('booking.categories');
})->middleware('auth')->name('home');

Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');

Route::get('/activities-list', [ActivityController::class, 'listAll'])->name('activities.list');
Route::get('/activity/{id}', [ActivityController::class, 'showDetail'])->name('activity.detail');

Route::get('/maps', function () {
    return view('user.maps');
})->name('maps.index');

Route::get('/contact-us', function () {
    return view('user.contact');
})->name('contact.us');

Route::get('/help-and-support', function () {
    return view('user.support');
})->name('help.support');

Route::get('/emergency', function () {
    return view('user.emergency');
})->name('emergency');

require __DIR__ . '/auth.php';

Route::middleware(['auth'])->group(function () {
    Route::get('/complete-profile', [ProfileCompletionController::class, 'showForm'])->name('profile.complete');
    Route::post('/complete-profile', [ProfileCompletionController::class, 'store'])->name('profile.store');

    Route::get('/dashboard', [ActivityController::class, 'index'])->name('dashboard');

    Route::get('/booking/categories', function () {
        $bookingDates = DB::table('booking_dates')->get();
        $slots = DB::table('slots')->get();
        $packages = DB::table('packages')->orderBy('id')->get();

        return view('booking.categories', compact('bookingDates', 'slots', 'packages'));
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

        return view('user.book-form', compact('categoryTitle', 'categoryInput'));
    })->name('book-form');

    Route::get('/my-bookings', function () {
        $bookings = DB::table('bookings')
            ->leftJoin('payments', 'bookings.id', '=', 'payments.booking_id')
            ->leftJoin('invoices', 'payments.id', '=', 'invoices.payment_id')
            ->select(
                'bookings.*',
                'payments.status as payment_status',
                'payments.receipt_url as payment_receipt',
                'invoices.invoice_url',
                'invoices.invoice_number'
            )
            ->where('bookings.client_id', Auth::id())
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        return view('user.MyBookings', compact('bookings'));
    })->name('my-bookings');

    Route::get('/payment/{reference_number}', [PaymentController::class, 'showPayment'])->name('payment.instruction');
    Route::post('/payment/{reference_number}/submit', [PaymentController::class, 'submitReceipt'])->name('payment.submit');
    Route::get('/payment/{reference_number}/status', [PaymentController::class, 'showStatus'])->name('payment.status');

    Route::get('/notifications', function () {
        $notifications = DB::table('notifications')->orderBy('created_at', 'desc')->get();

        return view('notifications', compact('notifications'));
    })->name('notifications.index');

    Route::get('/profile', function () {
        $profile = DB::table('profiles')->where('id', Auth::id())->first();

        if (! $profile) {
            return redirect()->route('profile.complete');
        }

        return view('user.profile', compact('profile'));
    })->name('profile.show');

    Route::get('/profile/edit', function () {
        $profile = DB::table('profiles')->where('id', Auth::id())->first();

        return view('user.profile-edit', compact('profile'));
    })->name('profile.edit');

    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/admin/login', function () {
    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    $admin = DB::table('admins')->where('email', $request->email)->first();

    if (! $admin || ! password_verify($request->password, $admin->password)) {
        return back()->withErrors([
            'email' => 'Invalid admin email or password.',
        ])->withInput();
    }

    $request->session()->regenerate();

    $request->session()->put('admin_logged_in', true);
    $request->session()->put('admin_id', $admin->id);
    $request->session()->put('admin_email', $admin->email);
    $request->session()->put('admin_name', $admin->full_name ?? 'Admin');

    return redirect()->route('admin.dashboard');
})->name('admin.login.submit');

Route::post('/admin/logout', function (Request $request) {
    $request->session()->forget([
        'admin_logged_in',
        'admin_id',
        'admin_email',
        'admin_name',
    ]);

    return redirect()->route('admin.login');
})->name('admin.logout');

Route::post('/admin/logout', function (Request $request) {
    $request->session()->forget([
        'admin_logged_in',
        'admin_id',
        'admin_email',
        'admin_name',
    ]);

    return redirect()->route('admin.login');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
    if (! session('admin_logged_in')) {
        return redirect()->route('admin.login');
    }

    $totalClients = DB::table('users')->count();

    $pendingBookings = DB::table('bookings')
        ->leftJoin('payments', 'bookings.id', '=', 'payments.booking_id')
        ->where(function ($query) {
            $query->whereNull('payments.status')
                ->orWhere('payments.status', 'pending');
        })
        ->count();

    $pendingPayments = DB::table('payments')
        ->where('status', 'pending')
        ->count();

    $blockedDatesCount = DB::table('booking_dates')
        ->where('status', '!=', 'fully_booked')
        ->count();

    $recentBookings = DB::table('bookings')
        ->leftJoin('payments', 'bookings.id', '=', 'payments.booking_id')
        ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
        ->select(
            'bookings.*',
            'payments.status as payment_status',
            'packages.name as package_name'
        )
        ->orderBy('bookings.created_at', 'desc')
        ->limit(5)
        ->get();

    $calendarBookings = DB::table('bookings')
        ->leftJoin('payments', 'bookings.id', '=', 'payments.booking_id')
        ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
        ->select(
            'bookings.id',
            'bookings.check_in_date',
            'bookings.check_out_date',
            'bookings.total_pax',
            'bookings.package_id',
            'bookings.selected_category',
            'payments.status as payment_status',
            'packages.name as package_name'
        )
        ->where('payments.status', 'approved')
        ->get();

    $calendarRestrictions = DB::table('booking_dates')
        ->where('status', '!=', 'fully_booked')
        ->get();

    return view('admin.dashboard', compact(
        'totalClients',
        'pendingBookings',
        'pendingPayments',
        'blockedDatesCount',
        'recentBookings',
        'calendarBookings',
        'calendarRestrictions'
    ));
})->name('dashboard');

    Route::get('/registered-clients', [RegisteredClientController::class, 'index'])->name('clients');

    Route::get('/booking-requests', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/booking-requests/{id}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');

    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::patch('/payments/{booking}/verify', [AdminPaymentController::class, 'verifyPayment'])->name('payments.verify');
    Route::post('/payments/{payment}/invoice', [AdminPaymentController::class, 'uploadInvoice'])->name('payments.uploadInvoice');

    Route::get('/slots', [SlotController::class, 'index'])->name('slots.index');
    Route::post('/slots', [SlotController::class, 'store'])->name('slots.store');
    Route::delete('/slots/{id}', [SlotController::class, 'destroy'])->name('slots.destroy');

    Route::get('/account-setting', function () {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $admin = DB::table('admins')->where('id', session('admin_id'))->first();

        return view('admin.account-setting', compact('admin'));
    })->name('account-setting');

    Route::put('/account-setting/password', function (Request $request) {
        if (! session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed'],
        ]);

        $admin = DB::table('admins')->where('id', session('admin_id'))->first();

        if (! $admin || ! password_verify($request->current_password, $admin->password)) {
            return back()->withErrors([
                'current_password' => 'Current password is incorrect.',
            ]);
        }

        DB::table('admins')->where('id', session('admin_id'))->update([
            'password' => password_hash($request->new_password, PASSWORD_BCRYPT),
        ]);

        return back()->with('success', 'Password updated successfully.');
    })->name('account-setting.password');
});
