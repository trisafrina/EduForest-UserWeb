<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin; // 1. Tukar daripada Model User kepada Model Admin
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 2. Semak keunikan emel di jadual 'admins', bukan lagi 'users'
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // 3. Masukkan data ke jadual 'admins'. Tiada lagi lajur 'is_admin' kerana jadual ini khas untuk admin.
        DB::table('admins')->insert([
            'full_name'  => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 4. Ambil semula data admin yang baru dimasukkan berdasarkan email daripada jadual 'admins'
        $adminData = DB::table('admins')->where('email', $request->email)->first();

        // 5. Tukarkan hasil data query menjadi objek Model Admin yang sah untuk sesi login Laravel
        $admin = Admin::hydrate([ (array) $adminData ])->first();
        
        event(new Registered($admin));

        // 6. Log masuk menggunakan guard('admin') yang kita daftarkan dalam config/auth.php tadi
        Auth::guard('admin')->login($admin);

        // 7. Bawa admin masuk terus ke route dashboard admin anda (Contoh: 'admin.dashboard' atau 'dashboard')
        return redirect(route('dashboard', absolute: false));
    }
}