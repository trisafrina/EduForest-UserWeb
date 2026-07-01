<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
<<<<<<< HEAD
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
=======
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
<<<<<<< HEAD
        // 1. Jalankan logik semakan pelbagai jadual yang kita pasang pada LoginRequest
        $request->authenticate();

        // 2. Cipta semula ID sesi pangkalan data untuk keselamatan
        $request->session()->regenerate();

        // 3. 🟢 JALAN PINTAS: Paksa sistem terus pergi ke dashboard, jangan guna intended() lagi
        return redirect('/dashboard');
=======
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $supabaseUrl = env('SUPABASE_URL');
        $supabaseKey = env('SUPABASE_KEY');

        // 1. Hantar emel & password ke Supabase Auth untuk semakan log masuk
        $response = Http::withHeaders([
            'apikey' => $supabaseKey,
            'Authorization' => 'Bearer ' . $supabaseKey,
            'Content-Type' => 'application/json',
        ])->post($supabaseUrl . '/auth/v1/token?grant_type=password', [
            'email' => $request->email,
            'password' => $request->password,
        ]);

        // Jika Supabase kata salah password atau emel tak wujud
        if ($response->failed()) {
            return back()->withErrors([
                'email' => 'The login information entered is incorrect or does not match.',
            ]);
        }

        $responseData = $response->json();
        
        // Ambil ID UUID daripada respon Supabase Auth
        $supabaseId = $responseData['user']['id'] ?? null;

        if (!$supabaseId) {
            return back()->withErrors([
                'email' => 'Failed to extract user data from Supabase.',
            ]);
        }

        // 2. Cari pengguna di table public.users berdasarkan ID UUID tersebut
        $user = User::find($supabaseId);

        // Jika data tiada dalam public.users, kita cipta rekod kilat untuk selaraskan session
        if (!$user) {
            $user = User::create([
                'id' => $supabaseId,
                'full_name' => $responseData['user']['user_metadata']['full_name'] ?? 'User',
                'email' => $request->email,
            ]);
        }

        // 3. Log masuk ke dalam sesi Laravel
        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // 👈 KITA UBAH DEKAT SINI!
        // Padam 'intended' lama, paksa terus masuk dashboard utama dengan selamat!
        return redirect()->route('dashboard');
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

<<<<<<< HEAD
        // 🟢 Bersihkan juga sisa-sisa sesi data admin/user manual yang kita simpan
        $request->session()->forget([
            'admin_logged_in', 'admin_id', 'admin_email', 'admin_name',
            'user_logged_in', 'user_id', 'user_email', 'user_name'
        ]);

=======
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}