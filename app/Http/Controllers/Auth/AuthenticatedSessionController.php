<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // 1. Jalankan logik semakan pelbagai jadual yang kita pasang pada LoginRequest
        $request->authenticate();

        // 2. Cipta semula ID sesi pangkalan data untuk keselamatan
        $request->session()->regenerate();

        // 3. 🟢 JALAN PINTAS: Paksa sistem terus pergi ke dashboard, jangan guna intended() lagi
        return redirect('/dashboard');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        // 🟢 Bersihkan juga sisa-sisa sesi data admin/user manual yang kita simpan
        $request->session()->forget([
            'admin_logged_in', 'admin_id', 'admin_email', 'admin_name',
            'user_logged_in', 'user_id', 'user_email', 'user_name'
        ]);

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}