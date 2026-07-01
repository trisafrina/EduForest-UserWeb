<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdminPaymentController extends Controller
{
    /**
     * Memaparkan semua senarai pembayaran pelanggan
     */
    public function index()
    {
        $payments = DB::table('bookings')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Mengesahkan pembayaran pelanggan
     */
    public function verifyPayment($id)
    {
        DB::table('bookings')
            ->where('id', $id)
            ->update([
                'status' => 'confirmed',
            ]);

        return redirect()->back()->with('success', 'Pembayaran pelanggan telah berjaya disahkan!');
    }
}