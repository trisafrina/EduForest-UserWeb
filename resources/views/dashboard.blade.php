<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduForest UCTC</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;800&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-stone-100 m-0 p-0 antialiased flex min-h-screen overflow-x-hidden">

    @php
        $dashboardProfile = DB::table('profiles')->where('id', Auth::id())->first();
        $userFullName = $dashboardProfile->full_name ?? Auth::user()->name;
        $profilePic = $dashboardProfile->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($userFullName) . '&background=355E3B&color=fff';
    @endphp

    <!-- ========================================== -->
    <!-- SIDEBAR KIRI (KEMAS & TIADA MASALAH TENGGELAM) -->
    <!-- ========================================== -->
    @include('profile.partials.sidebar')

    <!-- ========================================== -->
    <!-- KANDUNGAN UTAMA (SEBELAH KANAN)            -->
    <!-- ========================================== -->
    <div id="contentWrapper" class="flex-1 pl-68 min-h-screen flex flex-col transition-all duration-300 bg-stone-50">

        <!-- TOP NAVBAR -->
        <header class="bg-white h-20 shadow-sm flex items-center justify-between px-8 sticky top-0 z-30 border-b border-stone-200">
            
            <!-- Bahagian Kiri: Hamburger Menu & Input Search -->
            <div class="flex items-center space-x-6 flex-1 max-w-xl">
                <button id="toggleSidebarBtn" class="text-stone-600 hover:text-stone-900 p-2 rounded-lg hover:bg-stone-100 transition cursor-pointer focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <div class="relative w-full flex items-center">
                    <span class="absolute left-3 text-stone-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </span>
                    <input type="text" placeholder="Search for anything..." class="w-full pl-10 pr-4 py-2 bg-stone-50 border border-stone-200 rounded-lg text-xs focus:outline-none focus:border-[#355E3B] focus:bg-white transition text-stone-700 font-medium">
                </div>
            </div>

            <!-- Bahagian Kanan: BUTANG SETTING (RODA GEAR) & LOGOUT -->
            <div class="flex items-center space-x-3">
                <!-- Ikon Setting Roda Gear Tanpa Warna -->
                <a href="{{ route('profile.show') }}" class="p-2.5 text-stone-500 hover:text-stone-800 hover:bg-stone-100 rounded-xl transition border border-stone-200 shadow-sm" title="Account Settings">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.43l-1.003.767c-.29.222-.434.59-.38.954.004.03.006.06.006.09a7.195 7.195 0 0 1-.006.09c-.054.364.09.732.38.954l1.003.767a1.125 1.125 0 0 1 .26 1.43l-1.296 2.247a1.125 1.125 0 0 1-1.37.49l-1.216-.456c-.356-.133-.751-.072-1.076.124a6.517 6.517 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.43l1.004-.767c.29-.222.434-.59.38-.954a6.376 6.376 0 0 1-.006-.18c.054-.364-.09-.732-.38-.954l-1.004-.767a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.49l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </a>

                <!-- Butang Logout -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-xs bg-[#355E3B] hover:bg-[#2d5a43] text-white font-bold py-2 px-4 rounded-lg shadow-sm transition cursor-pointer tracking-wider uppercase">
                        Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- MAIN KANDUNGAN -->
        <main class="flex-1">
            <!-- ========================================== -->
            <!-- HERO SECTION                               -->
            <!-- ========================================== -->
            <div class="relative bg-black h-[500px] flex items-center justify-center overflow-hidden">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/6170282320066187830.jpg" 
                    class="absolute inset-0 w-full h-full object-cover opacity-60" alt="Muallim Visit River">
                
                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-white/50 text-4xl hidden md:block cursor-pointer hover:text-white">&lt;</div>

                <div class="relative z-10 text-center px-4 max-w-4xl flex flex-col items-center">
                    <h1 class="text-4xl md:text-5xl font-extrabold text-white tracking-tight uppercase mb-6 drop-shadow-lg">
                        Edu-Forest UPSI
                    </h1>
                    <div class="mt-4">
                        <a href="#about-eduforest" class="inline-block border-2 border-white text-white font-bold text-xs tracking-widest uppercase px-10 py-3.5 hover:bg-white hover:text-black transition duration-300">
                            See More
                        </a>
                    </div>
                </div>

                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-white/50 text-4xl hidden md:block cursor-pointer hover:text-white">&gt;</div>
            </div>

            <!-- ========================================== -->
            <!-- ABOUT SECTION                              -->
            <!-- ========================================== -->
            <div id="about-eduforest" class="py-20 bg-white border-b border-stone-200">
                <div class="max-w-4xl mx-auto px-6">
                    <div class="py-4 bg-white rounded-[2.5rem] my-2">
                        <h2 class="text-2xl font-extrabold text-gray-950 tracking-tight mb-4 uppercase">About Edu-Forest</h2>
                        <div class="w-12 h-1.5 bg-[#2d5a43] mb-6 rounded-full"></div>
                        
                        <div class="space-y-4 text-sm text-gray-700 leading-relaxed font-medium">
                            <p class="text-justify">
                                Universiti Pendidikan Sultan Idris (UPSI) Edu-Forest is a 10-hectare living laboratory and eco-adventure destination located within the lush Behrang Forest Reserve near Tanjung Malim, on the edge of the magnificent Titiwangsa Range. Developed and managed by UPSI, Edu-Forest combines environmental education, biodiversity conservation, ecotourism, and outdoor recreation in a natural rainforest setting, making it a unique destination for both learning and adventure. The station was granted a 30-year land use license by the Jabatan Perhutanan Negeri Perak beginning on 14 May 2019.
                            </p>
                            
                            <div id="more-about-text" class="hidden space-y-4">
                                <p class="text-justify">
                                    The area offers immersive nature-based experiences while also featuring stunning natural attractions. Beyond nature exploration, Edu-Forest is also known for its adrenaline-filled activities such as water tubing, jungle trekking, water confident, and many more. As a living lab, the site supports hands-on research and field studies in areas including biology, geography, environmental science, sports science, and ecotourism, providing students and researchers with real-world learning opportunities.
                                </p>
                                <p class="text-justify font-normal text-gray-700">
                                    Combining education, conservation, research, and adventure tourism, UPSI Edu-Forest serves as a gateway for people to reconnect with nature while promoting environmental awareness and sustainable ecosystem protection.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <button id="read-more-btn" onclick="toggleReadMore()" class="inline-block border border-stone-900 text-stone-900 hover:bg-stone-900 hover:text-white text-xs font-bold tracking-widest uppercase px-6 py-2.5 transition duration-300 cursor-pointer">
                            Read More
                        </button>
                    </div>
                </div>
            </div>

            <!-- ========================================== -->
            <!-- EXPLORE ACTIVITIES                         -->
            <!-- ========================================== -->
            <div id="explore" class="relative py-24 overflow-hidden shadow-inner">
                <div class="absolute inset-0 z-0">
                    <img src="https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=1200&q=80" 
                    class="w-full h-full object-cover brightness-[0.32] contrast-[1.08] filter blur-[1.5px]" alt="Dark Forest">
                </div>

                <div class="max-w-6xl mx-auto px-6 relative z-10">
                    <div class="mb-12 border-l-4 border-[#a3c5af] pl-4">
                        <h2 class="text-2xl font-extrabold text-white uppercase tracking-wide drop-shadow-sm">Explore Activities</h2>
                        <p class="text-gray-300 text-xs mt-1">List of existing training and recreation modules.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @forelse($activities as $activity)
                            <div class="bg-white rounded-[1.5rem] overflow-hidden shadow-2xl border border-white/10 transition transform hover:-translate-y-1 duration-300">
                                <div class="h-48 bg-stone-300 relative">
                                    <img src="{{ is_array($activity->image_urls) ? ($activity->image_urls[0] ?? '') : trim(explode(',', $activity->image_urls)[0]) }}" 
                                        class="w-full h-full object-cover" 
                                        alt="{{ $activity->name }}">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-base font-bold text-stone-900 mb-2 uppercase tracking-tight">{{ $activity->name }}</h3>
                                    <p class="text-stone-600 text-xs line-clamp-3 mb-4">{{ $activity->description }}</p>
                                    <span class="inline-block bg-[#2d5a43]/10 text-[#2d5a43] text-[10px] font-bold px-2.5 py-1 tracking-wider uppercase rounded-md">
                                        📍 {{ $activity->facilities ?? 'Standard' }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-3 text-center py-12 bg-white/10 backdrop-blur-md border border-dashed border-white/20 rounded-[1.5rem]">
                                <p class="text-gray-300 text-sm">Tiada data modul ditarik dari database.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- ========================================== -->
    <!-- JAVASCRIPT LOGIC                           -->
    <!-- ========================================== -->
    <script>
        // Logik Buka Tutup Sidebar
        const toggleSidebarBtn = document.getElementById('toggleSidebarBtn');
        const mainSidebar = document.getElementById('mainSidebar');
        const contentWrapper = document.getElementById('contentWrapper');

        toggleSidebarBtn.addEventListener('click', () => {
            if (mainSidebar.classList.contains('translate-x-0')) {
                mainSidebar.classList.remove('translate-x-0');
                mainSidebar.classList.add('-translate-x-full');
                contentWrapper.classList.remove('pl-68');
                contentWrapper.classList.add('pl-0');
            } else {
                mainSidebar.classList.remove('-translate-x-full');
                mainSidebar.classList.add('translate-x-0');
                contentWrapper.classList.remove('pl-0');
                contentWrapper.classList.add('pl-68');
            }
        });

        // Logik Read More About
        function toggleReadMore() {
            const content = document.getElementById('more-about-text');
            const btn = document.getElementById('read-more-btn');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                btn.textContent = 'Read Less';
            } else {
                content.classList.add('hidden');
                btn.textContent = 'Read More';
            }
        }
    </script>

</body>
</html>