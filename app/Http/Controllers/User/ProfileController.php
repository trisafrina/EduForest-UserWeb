<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone_number'  => 'nullable|string|max:20',
            'user_category' => 'nullable|string|max:255',
            'origin'        => 'nullable|string|max:255',
        ]);

        DB::table('profiles')->updateOrInsert(
            ['id' => Auth::id()],
            [
                'full_name'     => $request->full_name,
                'phone_number'  => $request->phone_number,
                'user_category' => $request->user_category,
                'origin'        => $request->origin,
                'updated_at'    => now(),
            ]
        );

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required'],
        ]);

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}