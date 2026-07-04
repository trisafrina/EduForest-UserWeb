<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminBookingController extends Controller
{
    public function index()
    {
        $bookings = DB::table('bookings')
            ->leftJoin('payments', 'bookings.id', '=', 'payments.booking_id')
            ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
            ->select(
                'bookings.*',
                'payments.id as payment_id',
                'payments.receipt_url as payment_receipt',
                'payments.status as payment_status',
                'packages.name as package_name'
            )
            ->orderBy('bookings.created_at', 'desc')
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = DB::table('bookings')->where('id', $id)->first();

        abort_if(! $booking, 404);

        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $booking = DB::table('bookings')->where('id', $id)->first();

        if (! $booking) {
            return redirect()->back()->withErrors([
                'booking' => 'Booking not found.',
            ]);
        }

        if ($request->status === 'approved') {
            DB::transaction(function () use ($booking, $id) {
                DB::table('payments')
                    ->where('booking_id', $id)
                    ->update([
                        'status' => 'approved',
                    ]);

                $this->markBookingDatesAsFullyBooked($booking);
            });

            return redirect()->back()->with('success', 'Booking approved and calendar updated.');
        }

        if ($request->status === 'rejected') {
            DB::transaction(function () use ($booking, $id) {
                DB::table('payments')
                    ->where('booking_id', $id)
                    ->update([
                        'status' => 'rejected',
                    ]);

                $this->clearBookingDates($booking);
            });

            return redirect()->back()->with('success', 'Booking rejected and dates are available again.');
        }

        return redirect()->back();
    }

    private function markBookingDatesAsFullyBooked($booking): void
    {
        if (empty($booking->check_in_date) || empty($booking->check_out_date)) {
            return;
        }

        $startDate = Carbon::parse($booking->check_in_date)->startOfDay();
        $endDate = Carbon::parse($booking->check_out_date)->startOfDay();

        while ($startDate->lte($endDate)) {
            $date = $startDate->format('Y-m-d');

            $existingDate = DB::table('booking_dates')
                ->whereDate('booking_date', $date)
                ->first();

            if ($existingDate) {
                DB::table('booking_dates')
                    ->where('id', $existingDate->id)
                    ->update([
                        'status' => 'fully_booked',
                    ]);
            } else {
                DB::table('booking_dates')->insert([
                    'id' => (string) Str::uuid(),
                    'booking_date' => $date,
                    'status' => 'fully_booked',
                    'created_at' => now(),
                ]);
            }

            $startDate->addDay();
        }
    }

    private function clearBookingDates($booking): void
    {
        if (empty($booking->check_in_date) || empty($booking->check_out_date)) {
            return;
        }

        $startDate = Carbon::parse($booking->check_in_date)->startOfDay();
        $endDate = Carbon::parse($booking->check_out_date)->startOfDay();

        while ($startDate->lte($endDate)) {
            $date = $startDate->format('Y-m-d');

            DB::table('booking_dates')
                ->whereDate('booking_date', $date)
                ->where('status', 'fully_booked')
                ->delete();

            $startDate->addDay();
        }
    }
}