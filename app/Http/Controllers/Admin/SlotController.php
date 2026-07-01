<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SlotController extends Controller
{
    public function index()
    {
        // Ambil semua data sekatan tarikh dari database
        $blockedDates = DB::table('booking_dates')
            ->orderBy('booking_date', 'asc')
            ->get();

        return view('admin.slots.index', compact('blockedDates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'booking_date' => 'required|date',
            'block_type' => 'required|in:holiday,fully_booked',
            'reason' => 'nullable|string|max:255',
        ]);

        // Semak jika tarikh tersebut sudah ada sekatan
        $exists = DB::table('booking_dates')
            ->where('booking_date', $request->booking_date)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Tarikh ini sudah mempunyai tetapan sekatan!');
        }

        // Tentukan nilai string status berdasarkan input borang
        $statusValue = $request->block_type;
        if ($request->block_type === 'holiday' && !empty($request->reason)) {
            $statusValue = 'Blocked (' . $request->reason . ')';
        } else if ($request->block_type === 'fully_booked') {
            $statusValue = 'fully_booked';
        }

        // Simpan data ke table booking_dates
        DB::table('booking_dates')->insert([
            'id' => \Illuminate\Support\Str::uuid(), // Memandangkan id jenis uuid
            'booking_date' => $request->booking_date,
            'status' => $statusValue,
            'created_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Sekatan kalendar berjaya dikemas kini!');
    }

    public function destroy($id)
    {
        DB::table('booking_dates')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Sekatan tarikh berjaya dipadam!');
    }
}