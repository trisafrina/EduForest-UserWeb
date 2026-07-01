<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
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
    }
}