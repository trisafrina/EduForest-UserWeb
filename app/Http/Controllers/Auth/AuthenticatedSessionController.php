<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}