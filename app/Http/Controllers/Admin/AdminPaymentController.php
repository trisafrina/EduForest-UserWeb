<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminPaymentController extends Controller
{
    public function __construct(private readonly SupabaseStorageService $storageService)
    {
    }

    public function index()
    {
        $payments = DB::table('payments')
            ->join('bookings', 'payments.booking_id', '=', 'bookings.id')
            ->leftJoin('packages', 'bookings.package_id', '=', 'packages.id')
            ->leftJoin('invoices', 'payments.id', '=', 'invoices.payment_id')
            ->select(
                'payments.id as payment_id',
                'payments.receipt_url',
                'payments.status as payment_status',
                'payments.created_at as payment_created_at',
                'bookings.id as booking_id',
                'bookings.client_name',
                'bookings.client_email',
                'bookings.selected_category',
                'bookings.package_id',
                'bookings.total_amount',
                'bookings.reference_number',
                'bookings.status as booking_status',
                'packages.name as package_name',
                'invoices.invoice_url',
                'invoices.invoice_number'
            )
            ->orderBy('payments.created_at', 'desc')
            ->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function verifyPayment($id)
    {
        $payment = DB::table('payments')->where('id', $id)->first();

        if (! $payment) {
            return redirect()->back()->withErrors([
                'payment' => 'Payment record not found.',
            ]);
        }

        DB::table('payments')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
            ]);

        return redirect()->back()->with('success', 'Payment receipt verified!');
    }

    public function uploadInvoice(Request $request, $id)
    {
        $request->validate([
            'invoice_file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $payment = DB::table('payments')->where('id', $id)->first();

        if (! $payment) {
            return redirect()->back()->withErrors([
                'invoice_file' => 'Payment record not found.',
            ]);
        }

        $booking = DB::table('bookings')->where('id', $payment->booking_id)->first();

        if (! $booking) {
            return redirect()->back()->withErrors([
                'invoice_file' => 'Booking record not found.',
            ]);
        }

        $file = $request->file('invoice_file');
        $extension = $file->getClientOriginalExtension();
        $fileName = 'invoice_' . $booking->reference_number . '_' . time() . '.' . $extension;

        $fileContent = file_get_contents($file->getRealPath());

        $uploadResult = $this->storageService->upload(
        'invoices',
        $fileName,
        $fileContent,
        $file->getMimeType()
        );
        

        if (! $uploadResult['ok']) {
            return redirect()->back()->withErrors([
                'invoice_file' => 'Invoice upload failed: ' . ($uploadResult['error'] ?? 'Please try again.'),
            ]);
        }

        $existingInvoice = DB::table('invoices')
            ->where('payment_id', $payment->id)
            ->first();

        if ($existingInvoice) {
            DB::table('invoices')
                ->where('id', $existingInvoice->id)
                ->update([
                    'invoice_url' => $uploadResult['public_url'],
                ]);
        } else {
            DB::table('invoices')->insert([
                'id' => (string) Str::uuid(),
                'created_at' => now(),
                'invoice_number' => 'INV' . rand(100000, 999999),
                'booking_id' => $booking->id,
                'payment_id' => $payment->id,
                'invoice_url' => $uploadResult['public_url'],
            ]);
        }

        return redirect()->back()->with('success', 'Invoice uploaded successfully!');
    }
}