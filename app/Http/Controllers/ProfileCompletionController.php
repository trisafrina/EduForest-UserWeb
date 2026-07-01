<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProfileCompletionController extends Controller
{
    // Papar form isi profil
    public function showForm()
    {
        // PERTAHANAN TAMBAHAN: Kalau user dah ada profil dalam database,
        // jangan bagi dia tengok form ni lagi, terus hantar ke dashboard!
        $profileExists = DB::table('profiles')->where('id', Auth::id())->exists();
        
        if ($profileExists) {
            return redirect()->route('dashboard');
        }

        return view('auth.complete-profile');
    }

    // Simpan data dari form ke Supabase
    public function store(Request $request)
    {
        $request->validate([
            'full_name'     => 'required|string|max:255',
            'phone_number'  => 'required|string|max:20',
            'user_category' => 'required|string',
            'origin'        => 'required|string|max:255',
        ]);

        $category = match ($request->user_category) {
            'upsi' => 'upsi_community',
            'gov' => 'government_agency',
            'government' => 'government_agency',
            'public' => 'public',
            'international' => 'international',
            default => $request->user_category,
        };

        $user = Auth::user();
        if ($user) {
            $user->name = $request->full_name;
            $user->save();
        }

        $profileData = [
            'id'            => Auth::id(),
            'full_name'     => $request->full_name,
            'phone_number'  => $request->phone_number,
            'role'          => 'client',
            'user_category' => $category,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];

        if (Schema::hasColumn('profiles', 'origin_organization')) {
            $profileData['origin_organization'] = $request->origin;
        }

        if (Schema::hasColumn('profiles', 'origin')) {
            $profileData['origin'] = $request->origin;
        }

        DB::table('profiles')->insert($profileData);

        // Selesai simpan, bawa ke dashboard dengan mesej kejayaan
        return redirect()->route('dashboard')->with('success', 'Profil berjaya dilengkapkan!');
    }
}