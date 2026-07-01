<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .shadow-custom { box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05), 0 8px 16px -6px rgba(0,0,0,0.03); }
        .divider-dash { border-top: 2px dashed #e5e7eb; }
    </style>
</head>
<body class="antialiased min-h-screen pb-16" style="background:linear-gradient(rgba(244,247,245,0.85),rgba(244,247,245,0.85)),url('https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1200&auto=format&fit=crop');background-size:cover;background-attachment:fixed;background-position:center;">

    <!-- HEADER -->
    <header class="bg-[#2d5a43] text-white rounded-b-[1.5rem] shadow-md sticky top-0 z-50">
        <div class="w-full px-6 py-5 flex items-center relative min-h-[66px]">
            <a href="javascript:history.back()" class="absolute left-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/15 hover:bg-white/25 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>
            <div class="w-full text-center">
                <h1 class="text-lg font-bold tracking-wide inline-block">Booking Confirmation</h1>
            </div>
        </div>
    </header>

    <main class="max-w-xl mx-auto px-4 mt-6">

        <div class="mb-4 pl-1">
            <h2 class="text-xl font-extrabold text-[#1e3522]">Confirm Your Booking</h2>
            <p class="text-xs text-gray-400 mt-0.5">Semak semula maklumat sebelum hantar</p>
        </div>

        @php
            $pName    = $bookingData['package_name'] ?? 'PACKAGE B';
            $pLabel   = $bookingData['package_label'] ?? '2 Days 1 Night';
            $pax      = intval($bookingData['total_pax'] ?? 1);
            $category = strtolower($bookingData['selected_category'] ?? 'public');
            $currency = ($category === 'international') ? 'USD' : 'RM';
            $pPrice   = $bookingData['price_per_pax'] ?? 0;
            $total    = $bookingData['total_amount'] ?? ($pPrice * $pax);
            $orgName  = $bookingData['organization_name'] ?? '-';

            // Activity icons per package
            $activityMap = [
                'PACKAGE A' => [
                    ['name'=>'Water Confident',  'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Water%20Confident/water%20confident.png'],
                    ['name'=>'Jungle Trekking',  'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Jungle%20Trekking/Jungle%20trekking.jpg'],
                    ['name'=>'River Crossing',   'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/River%20Crossing/river%20crossing.jpg'],
                ],
                'PACKAGE B' => [
                    ['name'=>'Water Confident',  'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Water%20Confident/water%20confident.png'],
                    ['name'=>'Jungle Trekking',  'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Jungle%20Trekking/Jungle%20trekking.jpg'],
                    ['name'=>'River Crossing',   'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/River%20Crossing/river%20crossing.jpg'],
                    ['name'=>'Orienteering',     'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Orienteering/Orienteering%20(2).jpg'],
                    ['name'=>'River Morphology', 'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/River%20Morphology/River%20Morphology.jpg'],
                    ['name'=>'Shelter',          'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Shelter/Shelter.jpg'],
                ],
                'PACKAGE C' => [
                    ['name'=>'Water Confident',  'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Water%20Confident/water%20confident.png'],
                    ['name'=>'Jungle Trekking',  'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Jungle%20Trekking/Jungle%20trekking.jpg'],
                    ['name'=>'River Crossing',   'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/River%20Crossing/river%20crossing.jpg'],
                    ['name'=>'Team Building',    'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Team%20Building/team%20building.jpg'],
                    ['name'=>'River Morphology', 'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/River%20Morphology/River%20Morphology.jpg'],
                    ['name'=>'Hiking',           'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Hiking%20to%20lubuk%20hantu/hiking%20lubuk%20hantu.jpg'],
                    ['name'=>'Orienteering',     'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Orienteering/Orienteering%20(2).jpg'],
                    ['name'=>'Shelter',          'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Shelter/Shelter.jpg'],
                    ['name'=>'Explorace',        'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Explorace/explorace.jpg'],
                    ['name'=>'Survival',         'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Survival/survival.jpg'],
                    ['name'=>'Water Tubing',     'img'=>'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/PACKAGE%20LOGO/Team%20Building/water%20tubing.jpg'],
                ],
            ];
            $badges = $activityMap[$pName] ?? $activityMap['PACKAGE B'];
        @endphp

        <div class="bg-white rounded-[2rem] p-5 shadow-custom border border-white/60 space-y-5">

            <!-- ── PACKAGE CARD ── -->
            <div class="bg-[#96b881]/40 border border-[#96b881]/60 rounded-[1.5rem] p-5">
                <div class="flex gap-4 items-start">
                    @php $pkgImg = $bookingData['package_image'] ?? null; @endphp
                    <img src="{{ $pkgImg ?: 'https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=150&auto=format&fit=crop' }}"
                        alt="{{ $pName }}" class="w-16 h-16 rounded-2xl object-cover border border-[#2d5a43]/20 shadow-sm">
                    <div class="flex-1">
                        <div class="flex justify-between items-start gap-2">
                            <div>
                                <h3 class="text-base font-black text-[#1e3522] tracking-wide">{{ $pName }}</h3>
                                <span class="inline-block bg-[#1e3522]/10 text-[#1e3522] text-[10px] font-black px-2 py-0.5 rounded-full mt-0.5">📅 {{ $pLabel }}</span>
                            </div>
                            <div class="text-right flex-shrink-0">
                                <p class="text-[10px] font-bold text-[#1e3522]">
                                    <span class="text-[9px]">{{ $currency }}</span>
                                    <span class="text-xl font-black">{{ $pPrice }}</span>
                                </p>
                                <p class="text-[9px] text-[#4d6e53] font-bold -mt-1">/ Person</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-t border-[#1e3522]/10 my-4"></div>

                <!-- Activity icons: SQUARE -->
                <div class="flex flex-wrap gap-x-3 gap-y-3">
                    @foreach($badges as $badge)
                    <div class="flex flex-col items-center w-12 text-center">
                        <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-sm border border-white/60 overflow-hidden p-1">
                            <img src="{{ $badge['img'] }}" alt="{{ $badge['name'] }}" class="w-full h-full object-cover rounded-lg">
                        </div>
                        <span class="text-[8px] font-bold text-[#1e3522] leading-tight mt-1 max-w-[48px]">{{ $badge['name'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- ── BOOKING DETAILS ── -->
            <div class="px-1 space-y-3">
                <h4 class="text-[10px] font-extrabold text-[#1e3522] uppercase tracking-widest">Booking Details</h4>

                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Check-In</span>
                    <span class="font-bold text-[#1e3522]">
                        {{ isset($bookingData['check_in_date']) ? date('d F Y', strtotime($bookingData['check_in_date'])) : '-' }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Check-Out</span>
                    <span class="font-bold text-[#1e3522]">
                        {{ isset($bookingData['check_out_date']) ? date('d F Y', strtotime($bookingData['check_out_date'])) : '-' }}
                    </span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Duration</span>
                    <span class="font-bold text-[#1e3522]">{{ $pLabel }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Pax</span>
                    <span class="font-bold text-[#1e3522]">{{ $pax }} Pax</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Category</span>
                    <span class="font-bold text-[#1e3522] uppercase">{{ $category }}</span>
                </div>
                @if($orgName && $orgName !== '-')
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Organization</span>
                    <span class="font-bold text-[#1e3522] text-right max-w-[200px]">{{ $orgName }}</span>
                </div>
                @endif
            </div>

            <div class="divider-dash mx-1"></div>

            <!-- ── CONTACT DETAILS ── -->
            <div class="px-1 space-y-3">
                <h4 class="text-[10px] font-extrabold text-[#1e3522] uppercase tracking-widest">Contact Details</h4>

                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Name</span>
                    <span class="font-bold text-[#1e3522] text-right max-w-[220px] truncate">{{ $bookingData['client_name'] ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Phone</span>
                    <span class="font-bold text-[#1e3522]">{{ $bookingData['client_number'] ?? '-' }}</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Email</span>
                    <span class="font-bold text-[#1e3522] truncate max-w-[200px]">{{ $bookingData['client_email'] ?? '-' }}</span>
                </div>
                @if(!empty($bookingData['special_requests']) && $bookingData['special_requests'] !== '-')
                <div class="flex justify-between items-start text-sm gap-4">
                    <span class="text-gray-400 font-bold flex-shrink-0">Notes</span>
                    <span class="font-medium text-[#1e3522] text-right text-xs leading-relaxed">{{ $bookingData['special_requests'] }}</span>
                </div>
                @endif

                @if(!empty($bookingData['participant_list_url']))
                <div class="flex justify-between items-center text-sm">
                    <span class="text-gray-400 font-bold">Participant List</span>
                    <a href="{{ $bookingData['participant_list_url'] }}" target="_blank" class="font-bold text-[#2d5a43] underline text-xs">View PDF ↗</a>
                </div>
                @endif
            </div>

            <div class="divider-dash mx-1"></div>

            <!-- ── TOTAL ── -->
            <div class="px-1 flex justify-between items-center">
                <span class="text-sm font-bold text-gray-400">Total Price</span>
                <span class="text-2xl font-black text-[#1e3522]">{{ $currency }} {{ number_format($total, 2) }}</span>
            </div>

        </div>

        <!-- SUBMIT & PAY -->
        <div class="mt-5">
            <a href="{{ route('payment.instruction', $bookingData['reference_number'] ?? 'ERROR') }}"
            class="block w-full bg-[#2d5a43] hover:bg-[#1e3522] text-white font-bold py-4 px-6 rounded-xl shadow-md active:scale-[0.99] transition-all text-center tracking-wide text-sm">
                Submit and Pay
            </a>
        </div>

    </main>
</body>
</html>
