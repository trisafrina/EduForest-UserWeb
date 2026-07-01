<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $booking->reference_number }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background: #f3f4f6; }
        @media print {
            body { background: #fff; }
            .no-print { display: none !important; }
            .invoice-card { box-shadow: none !important; border: 1px solid #e5e7eb !important; }
        }
    </style>
</head>
<body class="antialiased min-h-screen pb-16">

    <!-- Header (screen only) -->
    <header class="bg-[#2d5a43] text-white shadow-sm sticky top-0 z-50 no-print">
        <div class="w-full px-6 py-4 flex items-center relative min-h-[60px]">
            <a href="javascript:history.back()" class="absolute left-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/15 hover:bg-white/25 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>
            <div class="w-full text-center">
                <h1 class="text-base font-bold tracking-wide inline-block">Invoice</h1>
            </div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 mt-6">

        <!-- INVOICE CARD -->
        <div class="invoice-card bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">

            <!-- Invoice Header -->
            <div class="flex justify-between items-start">
                <div>
                    <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png"
                        alt="EduForest" class="h-14 w-auto object-contain mb-2">
                    <p class="text-xs font-bold text-gray-500">Edu-Forest UCTC UPSI</p>
                    <p class="text-[11px] text-gray-400">Universiti Pendidikan Sultan Idris</p>
                    <p class="text-[11px] text-gray-400">Tanjong Malim, Perak</p>
                </div>
                <div class="text-right">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Invoice</p>
                    <p class="text-lg font-black text-[#1e3522] tracking-wider">{{ $booking->reference_number }}</p>
                    <p class="text-[11px] text-gray-400 mt-1">
                        Tarikh: {{ now()->format('d F Y') }}
                    </p>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-800 border border-green-200 mt-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                        PAID
                    </span>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Billed To -->
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Billed To</p>
                    <p class="text-sm font-bold text-[#1e3522]">{{ $booking->client_name }}</p>
                    <p class="text-xs text-gray-500">{{ $booking->client_email }}</p>
                    <p class="text-xs text-gray-500">{{ $booking->client_number }}</p>
                    @if(!empty($booking->organization_name) && $booking->organization_name !== '-')
                    <p class="text-xs text-gray-500 mt-1">{{ $booking->organization_name }}</p>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Booking Details</p>
                    <p class="text-xs text-gray-500">Check-In: <span class="font-bold text-[#1e3522]">{{ isset($booking->check_in_date) ? date('d M Y', strtotime($booking->check_in_date)) : '-' }}</span></p>
                    <p class="text-xs text-gray-500 mt-0.5">Check-Out: <span class="font-bold text-[#1e3522]">{{ isset($booking->check_out_date) ? date('d M Y', strtotime($booking->check_out_date)) : '-' }}</span></p>
                    <p class="text-xs text-gray-500 mt-0.5">Category: <span class="font-bold text-[#1e3522] uppercase">{{ $booking->selected_category ?? '-' }}</span></p>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Items Table -->
            <div>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#a3c5af]/30 rounded-xl">
                            <th class="text-left text-[10px] font-black text-[#1e3522] uppercase tracking-wider px-4 py-2.5 rounded-l-xl">Description</th>
                            <th class="text-center text-[10px] font-black text-[#1e3522] uppercase tracking-wider px-3 py-2.5">Pax</th>
                            <th class="text-right text-[10px] font-black text-[#1e3522] uppercase tracking-wider px-4 py-2.5 rounded-r-xl">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $pax = intval($booking->total_pax ?? 1);
                            $total = floatval($booking->total_amount ?? 0);
                            $pricePerPax = $pax > 0 ? $total / $pax : $total;
                            $currency = strtolower($booking->selected_category ?? '') === 'international' ? 'USD' : 'RM';
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <p class="font-bold text-[#1e3522]">{{ $packageName }}</p>
                                <p class="text-[11px] text-gray-400 mt-0.5">Edu-Forest Outdoor Education Programme</p>
                            </td>
                            <td class="px-3 py-3 text-center text-gray-600 font-medium">{{ $pax }}</td>
                            <td class="px-4 py-3 text-right font-bold text-[#1e3522]">
                                {{ $currency }} {{ number_format($pricePerPax, 2) }} × {{ $pax }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="border-t border-gray-100"></div>

            <!-- Total -->
            <div class="flex justify-between items-center px-1">
                <span class="text-sm font-bold text-gray-400">Total Amount</span>
                <span class="text-2xl font-black text-[#1e3522]">{{ $currency }} {{ number_format($total, 2) }}</span>
            </div>

            <!-- Payment Ref -->
            <div class="bg-[#f0f7f3] border border-[#a3c5af]/40 rounded-2xl p-4 space-y-2 text-xs">
                <p class="font-black text-[#1e3522] uppercase tracking-wider text-[10px]">Payment Information</p>
                <div class="flex justify-between">
                    <span class="text-gray-500">Bank</span>
                    <span class="font-bold">Malayan Banking Berhad (Maybank)</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Account</span>
                    <span class="font-bold">UPSI Edu-Forest · 1234567890</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Reference</span>
                    <span class="font-mono font-bold text-[#2d5a43]">{{ $booking->reference_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-bold text-green-700">✅ Approved by Admin</span>
                </div>
            </div>

            <div class="text-center text-[10px] text-gray-400 pt-2">
                Terima kasih kerana memilih Edu-Forest UCTC UPSI. Selamat menikmati program anda!
            </div>

        </div>

        <!-- Download / Print Buttons -->
        <div class="mt-5 space-y-3 no-print">
            <button onclick="window.print()"
                class="flex items-center justify-center gap-2 w-full bg-[#2d5a43] hover:bg-[#1e3522] text-white font-bold py-4 px-6 rounded-xl shadow-md active:scale-[0.99] transition-all tracking-wide text-sm cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Download / Print Invoice
            </button>
            <a href="{{ route('dashboard') }}"
            class="block w-full bg-white hover:bg-gray-50 text-[#2d5a43] border border-[#2d5a43]/30 font-bold py-3.5 px-6 rounded-xl transition-all text-center tracking-wide text-sm">
                Back to Dashboard
            </a>
        </div>

    </main>
</body>
</html>
