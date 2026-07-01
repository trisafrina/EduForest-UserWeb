<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
=======
use App\Services\SupabaseStorageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function __construct(private readonly SupabaseStorageService $storageService)
    {
    }

>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

<<<<<<< HEAD
    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();
=======
/**
     * Kemas kini maklumat profil pengguna (Termasuk upload ke Supabase).
     */
    public function update(Request $request): RedirectResponse
    {
        // 1. Validasi mengikut field penuh dalam borang awak (image_344d57.png)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'user_category' => ['nullable', 'string', 'max:100'],
            'origin_organization' => ['nullable', 'string', 'max:255'],
            'profile_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'], // Had 2MB
        ]);

        $user = $request->user();

        // 2. Kemas kini nama dalam table 'users' asal
        $user->name = $request->name;

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
        $user->save();

        // Ambil data profil sedia ada (supaya kalau tak upload gambar baru, gambar lama tak hilang!)
        $existingProfile = DB::table('profiles')->where('id', $user->id)->first();
        $profileImageUrl = $existingProfile->profile_image_url ?? null;

        // 3. Proses Hantar Gambar ke Supabase Storage (Jika ada fail baru dipilih)
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            
            // Buat nama fail unik (contoh: avatar_1_1719600000.png) supaya tak bertembung cache
            $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $fileContents = file_get_contents($file->getRealPath());

            $bucketName = 'profile-images';
            $uploadResult = $this->storageService->upload(
                $bucketName,
                $fileName,
                $fileContents,
                $file->getClientMimeType()
            );

            if ($uploadResult['ok']) {
                $profileImageUrl = $uploadResult['public_url'];
            }
        }

        // 4. Masukkan atau Kemas kini data ke dalam table 'profiles'
        $profileData = [
            'full_name' => $request->name,
            'phone_number' => $request->phone_number,
            'user_category' => $request->user_category,
            'profile_image_url' => $profileImageUrl,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        if (Schema::hasColumn('profiles', 'origin_organization')) {
            $profileData['origin_organization'] = $request->origin_organization;
        }

        if (Schema::hasColumn('profiles', 'origin')) {
            $profileData['origin'] = $request->origin_organization;
        }

        DB::table('profiles')->updateOrInsert(
            ['id' => $user->id], // Cari row mengikut ID
            $profileData
        );
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
<<<<<<< HEAD
}
=======
} 
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
