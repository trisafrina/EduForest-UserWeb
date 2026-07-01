<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForest - Detail Aktiviti (Desktop)</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-stone-900 antialiased min-h-screen relative overflow-x-hidden">

    <div class="absolute inset-0 z-0">
        <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/6170282320066187830.jpg" 
            class="w-full h-full object-cover opacity-40 filter blur-xs" alt="Forest Background">
    </div>

    <div class="relative z-10 min-h-screen flex flex-col">
        
        <header class="bg-[#2d5a43]/95 backdrop-blur-md text-white shadow-md sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-8 py-4 flex items-center relative">
                <a href="javascript:history.back()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/15 hover:bg-white/25 transition-all absolute left-8">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <div class="w-full text-center">
                    <h1 class="text-lg font-bold tracking-wide">Activities</h1>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-8 my-auto py-12 w-full grid grid-cols-1 lg:grid-cols-12 gap-12 items-center flex-1">
            
            <div class="lg:col-span-7 relative group rounded-[2.5rem] overflow-hidden shadow-2xl border-4 border-white/10 aspect-video bg-stone-800">
                
                @php
                    $images = is_array($activity->image_urls) ? $activity->image_urls : (isset($activity->image_urls) ? explode(',', $activity->image_urls) : []);
                    $img1 = isset($images[0]) ? trim($images[0]) : 'https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1000&q=80';
                    $img2 = isset($images[1]) ? trim($images[1]) : 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?auto=format&fit=crop&w=1000&q=80';
                    $img3 = isset($images[2]) ? trim($images[2]) : 'https://images.unsplash.com/photo-1473448912268-2022ce9509d8?auto=format&fit=crop&w=1000&q=80';
                @endphp

                <div id="desktopSlider" class="flex w-full h-full transition-transform duration-500 ease-out">
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ $img1 }}" class="w-full h-full object-cover" alt="Slide 1">
                    </div>
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ $img2 }}" class="w-full h-full object-cover" alt="Slide 2">
                    </div>
                    <div class="w-full h-full flex-shrink-0">
                        <img src="{{ $img3 }}" class="w-full h-full object-cover" alt="Slide 3">
                    </div>
                </div>

                <button onclick="slidePrev()" class="absolute left-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/30 hover:bg-[#2d5a43] text-white flex items-center justify-center backdrop-blur-md transition opacity-0 group-hover:opacity-100 font-bold">❮</button>
                <button onclick="slideNext()" class="absolute right-4 top-1/2 -translate-y-1/2 w-11 h-11 rounded-full bg-black/30 hover:bg-[#2d5a43] text-white flex items-center justify-center backdrop-blur-md transition opacity-0 group-hover:opacity-100 font-bold">❯</button>

                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2.5">
                    <button onclick="goToSlide(0)" class="desktop-dot w-3 h-3 rounded-full bg-white transition-all duration-300"></button>
                    <button onclick="goToSlide(1)" class="desktop-dot w-3 h-3 rounded-full bg-white/40 transition-all duration-300"></button>
                    <button onclick="goToSlide(2)" class="desktop-dot w-3 h-3 rounded-full bg-white/40 transition-all duration-300"></button>
                </div>
            </div>

            <div class="lg:col-span-5 bg-white rounded-[2.5rem] p-10 shadow-[0_20px_50px_rgba(0,0,0,0.3)] border border-gray-100 flex flex-col justify-between min-h-[400px]">
                
                <div>
                    <div class="mb-6">
                        <h2 class="text-2xl font-extrabold text-gray-950 tracking-tight">
                            {{ $activity->name ?? 'Nama Aktiviti' }}
                        </h2>
                        <div class="w-12 h-1.5 bg-[#2d5a43] mt-2.5 rounded-full"></div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Overview</h4>
                        <p class="text-sm text-gray-700 leading-relaxed font-medium">
                            {{ $activity->overview ?? ($activity->description ?? 'No description available from Supabase.') }}
                        </p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Facilities Included</h4>
                        
                        <ul class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            @if(isset($activity->facilities))
                                @php
                                    $facilityList = is_array($activity->facilities) ? $activity->facilities : explode(',', $activity->facilities);
                                @endphp
                                @foreach($facilityList as $facility)
                                    <li class="text-sm text-gray-700 flex items-center gap-2.5 font-medium">
                                        <span class="w-2 h-2 rounded-full bg-emerald-600 flex-shrink-0"></span>
                                        {{ trim($facility) }}
                                    </li>
                                @endforeach
                            @else
                                <li class="text-sm text-gray-700 flex items-center gap-2.5 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-600"></span> Certified Tour Guide</li>
                                <li class="text-sm text-gray-700 flex items-center gap-2.5 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-600"></span> Emergency Bag & Kit</li>
                                <li class="text-sm text-gray-700 flex items-center gap-2.5 font-medium"><span class="w-2 h-2 rounded-full bg-emerald-600"></span> Safety Life Jacket</li>
                            @endif
                        </ul>
                    </div>

                    <div class="mb-6 inline-flex items-center gap-2.5 bg-[#2d5a43]/10 border border-[#2d5a43]/20 rounded-2xl px-4 py-3 shadow-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 text-[#2d5a43]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <span class="text-xs font-extrabold text-[#2d5a43] tracking-wide uppercase">
                            40 pax per session
                        </span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('booking.categories') }}" 
                    class="w-full py-4 bg-[#2d5a43] hover:bg-[#1e3d2d] active:scale-[0.99] text-white text-center font-bold rounded-2xl text-sm tracking-wide shadow-xl block transition-all">
                        Booking Now
                    </a>
                </div>

            </div>

        </main>
    </div>

    <script>
        let currentIdx = 0;
        const dSlider = document.getElementById('desktopSlider');
        const dDots = document.querySelectorAll('.desktop-dot');

        function updateDesktopSlider() {
            dSlider.style.transform = `translateX(-${currentIdx * 100}%)`;
            dDots.forEach((dot, index) => {
                if(index === currentIdx) {
                    dot.classList.remove('bg-white/40');
                    dot.classList.add('bg-white', 'w-7'); 
                } else {
                    dot.classList.remove('bg-white', 'w-7');
                    dot.classList.add('bg-white/40');
                }
            });
        }

        function slideNext() {
            currentIdx = (currentIdx + 1) % 3;
            updateDesktopSlider();
        }

        function slidePrev() {
            currentIdx = (currentIdx - 1 + 3) % 3;
            updateDesktopSlider();
        }

        function goToSlide(index) {
            currentIdx = index;
            updateDesktopSlider();
        }

        setInterval(slideNext, 5000); // Auto-rotate perlahan setiap 5 saat
        updateDesktopSlider();
    </script>
</body>
</html>