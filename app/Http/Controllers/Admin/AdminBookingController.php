<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBookingController extends Controller
{
    /**
     * Senarai semua permohonan tempahan (Booking Requests)
     */
    public function index()
    {
        $bookings = DB::table('bookings')
            ->leftJoin('payments', 'bookings.id', '=', 'payments.booking_id')
            ->select(
                'bookings.*',
                'payments.receipt_url as payment_receipt',
                'payments.status as payment_status'
            )
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Papar butiran satu permohonan tempahan
     */
    public function show($id)
    {
        $booking = DB::table('bookings')->where('id', $id)->first();

        abort_if(!$booking, 404);

        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Kemaskini status tempahan (approve / reject)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,paid',
        ]);

        DB::table('bookings')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Booking operational status updated!');
    }
}