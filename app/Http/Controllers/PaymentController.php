<?php

namespace App\Http\Controllers;

use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function __construct(private readonly SupabaseStorageService $storageService)
    {
    }

    // Helper: resolve package name from package_id integer
    private function resolvePackageName($packageId): string
    {
        $map = [1 => 'PACKAGE A', 2 => 'PACKAGE B', 3 => 'PACKAGE C'];
        return $map[intval($packageId)] ?? ('PACKAGE ' . $packageId);
    }

    // 1. Show payment instruction page
    public function showPayment($reference_number)
    {
        $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();
        if (!$booking) abort(404, 'Maklumat tempahan tidak ditemui.');

        // Resolve package name for display
        $packageName = $this->resolvePackageName($booking->package_id);

        return view('payment.instruction', compact('booking', 'packageName'));
    }

    // 2. Submit receipt — upload to Supabase storage, bypass PHP temp file
    public function submitReceipt(Request $request, $reference_number)
    {
        $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();
        if (!$booking) abort(404, 'Maklumat tempahan tidak ditemui.');

        $receiptUrl = 'pending_upload_local';

        // ── Upload receipt to Supabase 'payment-receipts' bucket ──────────────
        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');

            // Read file content directly — avoids PHP tmp dir issue
            $fileContent = file_get_contents($file->getRealPath());
            $mimeType    = $file->getClientMimeType();
            $ext         = $file->getClientOriginalExtension();

            // Filename: EDU<reference>_receipt_<timestamp>.<ext>
            $fileName = $booking->reference_number . '_receipt_' . time() . '.' . $ext;

            $uploadResult = $this->storageService->upload(
                'payment-receipts',
                $fileName,
                $fileContent,
                $mimeType
            );

            if ($uploadResult['ok']) {
                $receiptUrl = $uploadResult['public_url'];
            }
        }
        // ─────────────────────────────────────────────────────────────────────

        // Insert into payments table
        DB::table('payments')->insert([
            'booking_id'  => $booking->id,
            'receipt_url' => $receiptUrl,
            'status'      => 'pending',
            'created_at'  => now(),
        ]);

        // Update booking status
        DB::table('bookings')
            ->where('reference_number', $reference_number)
            ->update(['status' => 'pending']);

        return redirect()->route('payment.status', $reference_number)
                         ->with('success', 'Resit anda berjaya dihantar!');
    }

    // 3. Show "Receipt Submitted" status page
    public function showStatus($reference_number)
    {
        $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();
        if (!$booking) abort(404, 'Maklumat tempahan tidak ditemui.');

        $packageName = $this->resolvePackageName($booking->package_id);

        // Check if admin has approved (status = 'approved' in payments table)
        $payment = DB::table('payments')
            ->where('booking_id', $booking->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $isApproved = $payment && strtolower($payment->status ?? '') === 'approved';

        return view('payment.status', compact('booking', 'packageName', 'payment', 'isApproved'));
    }

    // 4. Download invoice (only if approved)
    public function downloadInvoice($reference_number)
    {
        $booking = DB::table('bookings')->where('reference_number', $reference_number)->first();
        if (!$booking) abort(404);

        $payment = DB::table('payments')
            ->where('booking_id', $booking->id)
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$payment || strtolower($payment->status ?? '') !== 'approved') {
            abort(403, 'Invoice belum diluluskan oleh admin.');
        }

        $packageName = $this->resolvePackageName($booking->package_id);

        return view('payment.invoice', compact('booking', 'packageName', 'payment'));
    }
}
