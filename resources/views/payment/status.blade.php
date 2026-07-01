<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(rgba(244,247,245,0.85),rgba(244,247,245,0.85)),
                        url('https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1200&auto=format&fit=crop');
            background-size: cover; background-attachment: fixed; background-position: center;
        }
        .shadow-custom { box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05), 0 8px 16px -6px rgba(0,0,0,0.03); }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col justify-between pb-8">

    <main class="max-w-xl w-full mx-auto px-4 mt-12 flex-1 flex flex-col justify-center">

        <div class="bg-white rounded-[2rem] p-8 shadow-custom border border-white/60 text-center space-y-6">

            @if($isApproved)
            {{-- ✅ APPROVED STATE --}}
            <div class="w-20 h-20 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <div class="space-y-2">
                <h2 class="text-2xl font-black text-[#1e3522]">Payment Approved! 🎉</h2>
                <p class="text-sm text-gray-500 font-medium leading-relaxed px-2">
                    Pembayaran anda telah disahkan oleh admin. Anda boleh muat turun invois sekarang.
                </p>
            </div>
            @else
            {{-- ⏳ PENDING STATE --}}
            <div class="w-20 h-20 bg-[#2d5a43]/10 text-[#2d5a43] rounded-full flex items-center justify-center mx-auto animate-pulse shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
            </div>
            <div class="space-y-2">
                <h2 class="text-2xl font-black text-[#1e3522]">Receipt Submitted!</h2>
                <p class="text-sm text-gray-500 font-medium leading-relaxed px-2">
                    Terima kasih! Resit pembayaran anda berjaya dihantar dan sedang menunggu
                    <span class="text-[#2d5a43] font-bold">pengesahan admin</span>.
                    Butang muat turun invois akan tersedia selepas diluluskan.
                </p>
            </div>
            @endif

            <div class="border-t border-dashed border-gray-100 mx-2"></div>

            <!-- Booking Summary -->
            <div class="bg-gray-50/70 border border-gray-100 rounded-2xl p-4 space-y-3 text-left text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-400 font-bold">Reference No.</span>
                    <span class="font-mono font-black text-[#1e3522] tracking-wider">{{ $booking->reference_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400 font-bold">Package</span>
                    {{-- ✅ Proper package name --}}
                    <span class="font-extrabold text-[#1e3522]">{{ $packageName }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400 font-bold">Pax</span>
                    <span class="font-bold text-[#1e3522]">{{ $booking->total_pax ?? 1 }} Pax</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400 font-bold">Total Amount</span>
                    <span class="font-black text-[#2d5a43]">
                        @if(strtolower($booking->selected_category ?? '') === 'international') USD @else RM @endif
                        {{ number_format($booking->total_amount ?? 0, 2) }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 font-bold">Status</span>
                    @if($isApproved)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-50 text-green-800 border border-green-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Approved
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-200">
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-ping"></span>
                            Pending Approval
                        </span>
                    @endif
                </div>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="mt-5 space-y-3">

            @if($isApproved)
            {{-- ✅ Download Invoice button (only shown when approved) --}}
            <a href="{{ route('payment.invoice', $booking->reference_number) }}"
               class="flex items-center justify-center gap-2 w-full bg-[#2d5a43] hover:bg-[#1e3522] text-white font-bold py-4 px-6 rounded-xl shadow-md active:scale-[0.99] transition-all tracking-wide text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Download Invoice
            </a>
            @else
            {{-- Greyed out — not yet approved --}}
            <div class="flex items-center justify-center gap-2 w-full bg-gray-200 text-gray-400 font-bold py-4 px-6 rounded-xl tracking-wide text-sm cursor-not-allowed select-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                </svg>
                Download Invoice (Menunggu Kelulusan)
            </div>
            @endif

            <a href="{{ route('dashboard') }}"
            class="block w-full bg-white hover:bg-gray-50 text-[#2d5a43] border border-[#2d5a43]/30 font-bold py-3.5 px-6 rounded-xl transition-all text-center tracking-wide text-sm">
                Back to Dashboard
            </a>
        </div>

    </main>

    <footer class="text-center text-[11px] text-gray-400 font-bold mt-8">
        © 2026 Edu-Forest UCTC UPSI. All Rights Reserved.
    </footer>

</body>
</html>
