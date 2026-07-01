<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Package;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    // 1. Papar Halaman Utama Dashboard (Sedia ada - Tidak terusik)
    public function index()
    {
        // Ambil semua data aktiviti dari Supabase
        $activities = Activity::all();
        
        return view('dashboard', compact('activities'));
    }

    // 2. Papar Senarai Pakej di bawah Kategori Kumpulan (Sedia ada)
   // 2. Papar Senarai Pakej di bawah Kategori Kumpulan (UPSI, Awam, Government)
    public function showPackages($category)
    {
        // Ambil semua pakej dari Supabase
        $packages = Package::all();

        // TUKAR DARIPADA 'booking-form' KEPADA 'book-form' SUPAYA SEPADAN DENGAN BLADE AWAK
        return view('book-form', compact('packages', 'category'));
    }

    // 3. Papar Halaman Senarai Aktiviti Grid Khas (Katalog Detail)
    public function listAll()
    {
        // Gantikan panggilan DB biasa kepada Model Eloquent sedia ada awak
        $activities = Activity::all(); 

        return view('activities-list', compact('activities'));
    }

    // 4. JALAN BARU: Papar Halaman Detail Setiap Aktiviti (Mempunyai 3 Gambar Swipe)
    public function showDetail($id)
    {
        // Cari aktiviti berdasarkan ID yang diklik. Jika tiada, ia akan keluar error 404.
        $activity = Activity::findOrFail($id);

        // Supaya senarai fasiliti fleksibel, kita semak jika data dalam database disimpan sebagai teks string biasa (cth: "Tour Guide, Life Jacket")
        // Kita pecahkan ia menjadi susunan array supaya kod blade dapat proses dengan teratur.
        if (isset($activity->facilities) && !is_array($activity->facilities)) {
            $activity->facilities = array_map('trim', explode(',', $activity->facilities));
        }

        return view('activity-detail', compact('activity'));
    }
}