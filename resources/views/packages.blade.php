<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Package Selection</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .shadow-custom { box-shadow: 0 10px 25px -5px rgba(0,0,0,0.08), 0 8px 16px -6px rgba(0,0,0,0.04); }
    </style>
</head>
<body class="antialiased min-h-screen pb-12" style="background:linear-gradient(rgba(244,247,245,0.85),rgba(244,247,245,0.85)),url('https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=1200&auto=format&fit=crop');background-size:cover;background-attachment:fixed;background-position:center;">

    <!-- HEADER -->
    <header class="bg-[#2d5a43] text-white rounded-b-[1.5rem] shadow-md sticky top-0 z-50">
        <div class="w-full px-6 py-5 flex items-center relative min-h-[66px]">
            <a href="{{ route('booking.categories') }}" class="absolute left-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/15 hover:bg-white/25 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
                </svg>
            </a>
            <div class="w-full text-center">
                <h1 class="text-lg font-bold tracking-wide inline-block">Package Selection</h1>
            </div>
            <div class="absolute right-6 bg-white/10 text-white text-[11px] font-semibold px-3 py-1.5 rounded-full border border-white/20">
                {{ $categoryTitle }}
            </div>
        </div>
    </header>

    <main class="max-w-2xl mx-auto px-4 mt-6 space-y-6">

        @php
        $packageActivities = [
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

        $packageDurations = [
            'PACKAGE A' => ['label'=>'1 Day',             'days'=>1],
            'PACKAGE B' => ['label'=>'2 Days 1 Night',    'days'=>2],
            'PACKAGE C' => ['label'=>'3 Days 2 Nights',   'days'=>3],
        ];

        // Subtitle titles per package (fallback jika tiada dalam DB)
        $packageTitles = [
            'PACKAGE A' => 'Nature Explorer',
            'PACKAGE B' => 'Adventure Seeker',
            'PACKAGE C' => 'Ultimate Experience',
        ];
        @endphp

        @foreach($packages as $package)
        @php
            $pkgUpper   = strtoupper($package->name);
            $activities = $packageActivities[$pkgUpper] ?? [];
            $duration   = $packageDurations[$pkgUpper]  ?? ['label'=>'1 Day','days'=>1];
            // ✅ Ambil subtitle dari Supabase, fallback ke default jika kosong
            $subtitle   = !empty($package->subtitle) ? $package->subtitle : ($packageTitles[$pkgUpper] ?? '');
        @endphp

        <div class="bg-white rounded-[2rem] p-4 shadow-custom border border-white/60">
            <div class="bg-[#a3c5af] rounded-[1.6rem] p-5 text-[#1e3522]">

                <!-- TOP ROW: image + title + price -->
                <div class="flex gap-4 items-start justify-between">
                    <div class="flex gap-4 items-start flex-1 min-w-0">
                        <!-- Package image: square rounded -->
                        <div class="w-20 h-24 rounded-2xl overflow-hidden bg-white/40 flex-shrink-0 shadow-sm border border-white/20">
                            @if(isset($package->image_url) && filter_var($package->image_url, FILTER_VALIDATE_URL))
                                <img src="{{ $package->image_url }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                            @else
                                <img src="https://images.unsplash.com/photo-1473448912268-2022ce9509d8?w=300&auto=format&fit=crop" alt="EduForest" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1 space-y-1 min-w-0">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h2 class="font-extrabold text-xl tracking-tight">{{ $package->name }}</h2>
                                <span class="text-sm">⛰️</span>
                            </div>
                            <!-- Duration badge -->
                            <span class="inline-block bg-[#1e3522]/15 text-[#1e3522] text-[10px] font-black px-2.5 py-1 rounded-full tracking-wide">📅 {{ $duration['label'] }}</span>
                            {{-- ✅ SUBTITLE dari Supabase --}}
                            @if($subtitle)
                            <p class="text-[12px] font-bold text-[#1e3522] pt-0.5">{{ $subtitle }}</p>
                            @endif
                            @if(!empty($package->description))
                            <p class="text-[10px] font-medium leading-tight opacity-80 max-w-xs pt-0.5">{{ $package->description }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="text-right flex-shrink-0 pl-2">
                        <span class="font-extrabold text-xl tracking-tight">
                            <span class="text-xs font-bold mr-0.5">{{ $currency }}</span>{{ number_format($package->$priceColumn, 0) }}
                        </span>
                        <span class="text-[10px] font-bold opacity-75 block -mt-1">/ Person</span>
                    </div>
                </div>

                <div class="border-t border-[#1e3522]/15 my-4 w-full"></div>

                <!-- ACTIVITY ICONS: square -->
                <div class="flex items-end justify-between gap-2">
                    <div class="flex flex-wrap gap-x-3 gap-y-3 items-start pt-1 flex-1">
                        @foreach($activities as $act)
                        <div class="flex flex-col items-center w-12 text-center">
                            <div class="w-11 h-11 bg-white rounded-xl flex items-center justify-center shadow-sm p-1.5 border border-white/60 overflow-hidden">
                                <img src="{{ $act['img'] }}" alt="{{ $act['name'] }}" class="w-full h-full object-cover rounded-lg">
                            </div>
                            <span class="text-[8.5px] font-bold tracking-tight text-[#1e3522] mt-1 leading-tight">{{ $act['name'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    <!-- Select arrow button — passes ALL needed params -->
                    <a href="{{ route('book-form', [
                            'category'      => request()->query('category', 'upsi'),
                            'package_id'    => $package->id,
                            'package_name'  => $package->name,
                            'package_days'  => $duration['days'],
                            'package_label' => $duration['label'],
                        ]) }}"
                    class="w-10 h-10 rounded-full bg-[#1e3522] hover:bg-[#111e14] text-white flex items-center justify-center shadow transition-all shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3.5" stroke="currentColor" class="w-3.5 h-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </a>
                </div>

            </div>
        </div>
        @endforeach

    </main>
</body>
</html>
