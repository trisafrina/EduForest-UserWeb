<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Services\SupabaseStorageService;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function __construct(private readonly SupabaseStorageService $storageService)
    {
    }

    public function store(Request $request)
    {
        // (legacy) placeholder
    }

    public function showConfirmation(Request $request)
    {
        // ── 1. Package & Category ──────────────────────────────────────
        $pIdInput  = $request->input('package_id');
        $pName     = strtoupper($request->input('package_name', 'PACKAGE B'));
        $pDays     = intval($request->input('package_days', 2));
        $category  = strtolower($request->input('category', 'public'));
        $pax       = intval($request->input('total_pax', 1));

        // ── FIX: Resolve package ID dengan betul ──────────────────────
        // Ambil HURUF TERAKHIR nama pakej ("PACKAGE A" → "A")
        // str_contains() tidak boleh dipakai — "package" mengandungi 'a' dan 'c'!
        $lastChar = strtoupper(trim(substr($pName, -1))); // → "A", "B", atau "C"

        if (intval($pIdInput) === 1 || $lastChar === 'A') {
            $packageIdDb = 1;
        } elseif (intval($pIdInput) === 3 || $lastChar === 'C') {
            $packageIdDb = 3;
        } else {
            $packageIdDb = 2;
        }
        // ─────────────────────────────────────────────────────────────

        // ── 2. Price by category — ikut supabase packages table ──────
        $prices = [
            1 => ['upsi'=>40,  'gov'=>50,  'government'=>50,  'international'=>36,  'public'=>60],
            2 => ['upsi'=>70,  'gov'=>85,  'government'=>85,  'international'=>71,  'public'=>100],
            3 => ['upsi'=>110, 'gov'=>130, 'government'=>130, 'international'=>91,  'public'=>150],
        ];
        $pPrice          = $prices[$packageIdDb][$category] ?? $prices[$packageIdDb]['public'];
        $calculatedTotal = $pPrice * $pax;

        // ── 3. Dates ──────────────────────────────────────────────────
        $checkInDate  = $request->input('booking_date');
        $checkOutDate = $request->input('checkout_date');

        if (!$checkOutDate && $checkInDate) {
            $d = new \DateTime($checkInDate);
            $d->modify('+' . ($pDays - 1) . ' days');
            $checkOutDate = $d->format('Y-m-d');
        }

        // ── 4. Upload PDF participant list → Supabase ─────────────────
        $participantListUrl = null;
        if ($request->hasFile('participant_list_pdf')) {
            $file = $request->file('participant_list_pdf');

            try {
                $fileContent = file_get_contents($file->getRealPath());
            } catch (\Throwable $e) {
                return back()->withErrors([
                    'participant_list_pdf' => 'Ralat semasa membaca fail PDF. Sila cuba lagi atau pilih fail yang lebih kecil.'
                ])->withInput();
            }

            if ($fileContent === false || $fileContent === '') {
                return back()->withErrors([
                    'participant_list_pdf' => 'Fail PDF tidak dapat dibaca. Sila pilih fail lain.'
                ])->withInput();
            }

            $fileName = 'participants_' . Auth::id() . '_' . time() . '.pdf';

            $uploadResult = $this->storageService->upload(
                'participant-lists',
                $fileName,
                $fileContent,
                'application/pdf'
            );

            if ($uploadResult['ok']) {
                $participantListUrl = $uploadResult['public_url'];
            } else {
                return back()->withErrors([
                    'participant_list_pdf' => 'Upload PDF gagal: ' . ($uploadResult['error'] ?? 'Sila cuba lagi.')
                ])->withInput();
            }
        }

        // ── 5. Insert booking ─────────────────────────────────────────
        $newUuid         = (string) Str::uuid();
        $referenceNumber = 'EDU' . rand(100000, 999999);
        $clientId        = Auth::check() ? Auth::id() : (string) Str::uuid();

        DB::table('bookings')->insert([
            'id'                   => $newUuid,
            'client_id'            => $clientId,
            'package_id'           => $packageIdDb,
            'slot_id'              => null,
            'check_in_date'        => $checkInDate,
            'check_out_date'       => $checkOutDate,
            'total_pax'            => $pax,
            'selected_category'    => $category,
            'category_detail'      => $request->input('organization_name', '-'),
            'client_name'          => $request->input('client_name'),
            'client_number'        => $request->input('client_number'),
            'client_email'         => $request->input('client_email'),
            'special_requests'     => $request->input('special_requests', '-'),
            'participant_list_url' => $participantListUrl,
            'total_amount'         => $calculatedTotal,
            'status'               => 'pending',
            'reference_number'     => $referenceNumber,
            'created_at'           => now(),
        ]);

        $bookingFromDb = DB::table('bookings')->where('id', $newUuid)->first();
        $bookingData   = (array) $bookingFromDb;

        // Ambil image_url dari packages table
        $packageRow = DB::table('packages')->where('id', $packageIdDb)->first();

        // Tambah maklumat display yang tak disimpan dalam DB
        $bookingData['package_name']  = $pName;
        $bookingData['package_label'] = $request->input('package_label', '2 Days 1 Night');
        $bookingData['price_per_pax'] = $pPrice;
        $bookingData['package_image'] = $packageRow->image_url ?? null;

        return view('booking-confirmation', compact('bookingData'));
    }
}
