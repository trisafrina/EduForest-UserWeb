<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
<<<<<<< HEAD
use App\Models\Admin; // 1. Tukar daripada Model User kepada Model Admin
=======
use App\Models\User;
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
<<<<<<< HEAD
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
=======
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
    public function create(): View
    {
        return view('auth.register');
    }

<<<<<<< HEAD
    /**
     * Handle an incoming registration request.
     */
=======
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
<<<<<<< HEAD
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
=======
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');

        // 1. Simpan Email & Password ke Supabase Auth (Sistem Authentication Rahsia)
        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => 'application/json',
        ])->post($supabaseUrl . '/auth/v1/signup', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($response->failed()) {
            return back()->withErrors(['email' => 'Pendaftaran Supabase Auth Gagal: ' . ($response->json()['msg'] ?? $response->body())]);
        }

        $responseData = $response->json();

        // Tangkap ID UUID yang dijana dari auth.users Supabase
        $supabaseId = null;
        if (isset($responseData['id'])) {
            $supabaseId = $responseData['id'];
        } elseif (isset($responseData['user']['id'])) {
            $supabaseId = $responseData['user']['id'];
        }

        if (!$supabaseId) {
            return back()->withErrors(['email' => 'Sila semak peti masuk emel anda untuk mengesahkan akaun sebelum log masuk.']);
        }

        // 2. Simpan maklumat profil sahaja ke table public.users (Tanpa Kolum Password)
        $user = User::create([
            'id'        => $supabaseId,             
            'full_name' => $request->name,          
            'email'     => $request->email,
            'created_at' => now(),
        ]);

        event(new Registered($user));

        // Log masuk ke Laravel Session
        Auth::login($user);

        // DI SINI KITA TUKAR IKUT ROUTE PROFILE:
        return redirect()->route('profile.complete');
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
    }
}