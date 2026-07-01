@php
    $sbProfileRow = isset($dashboardProfile) ? $dashboardProfile : DB::table('profiles')->where('id', Auth::id())->first();
    $userFullName = $userFullName ?? ($sbProfileRow->full_name ?? Auth::user()->name);
    $profilePic = $profilePic ?? ($sbProfileRow->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($userFullName) . '&background=355E3B&color=fff');
@endphp

<!-- ========================================== -->
<!-- SIDEBAR KIRI (KEMAS & TIADA MASALAH TENGGELAM) -->
<!-- ========================================== -->
<aside id="mainSidebar" class="w-68 bg-[#355E3B] text-white fixed h-full top-0 left-0 z-40 flex flex-col justify-between shadow-xl border-r border-black/10 transition-transform duration-300 translate-x-0">
    <div>
        <!-- 1. LOGO ATAS SEKALI -->
        <div class="h-28 flex items-center justify-center border-b border-white/10 px-4 bg-[#2d5a43]">
            <a href="{{ route('dashboard') }}" class="block">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png" 
                alt="Logo EduForest" 
                class="h-24 w-auto object-contain scale-125 drop-shadow-lg transition-transform hover:scale-130">
            </a>
        </div>

        <!-- 2. SECTION PROFIL -->
        <div class="p-6 text-center border-b border-white/10 bg-gradient-to-b from-[#2d5a43] to-[#355E3B]">
            <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-amber-500 mx-auto shadow-md flex items-center justify-center bg-stone-50 mb-3">
                <img src="{{ $profilePic }}" class="w-full h-full object-cover" alt="User Avatar">
            </div>
            <h4 class="font-bold text-white text-xs tracking-wide uppercase px-2 line-clamp-2 leading-tight">
                {{ $userFullName }}
            </h4>
            <p class="text-[10px] text-stone-300 mt-1 truncate max-w-full px-2">
                {{ Auth::user()->email }}
            </p>
        </div>

        <!-- 3. NAVIGASI MENU MENEGAK -->
        <nav class="p-4 space-y-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-stone-100 hover:bg-white/10 transition text-xs font-bold tracking-wide uppercase group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span>Home</span>
            </a>
            
            <a href="{{ route('activities.list') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-stone-100 hover:bg-white/10 transition text-xs font-bold tracking-wide uppercase group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                </svg>
                <span>Activities</span>
            </a>
            
            <a href="{{ route('maps.index') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-stone-100 hover:bg-white/10 transition text-xs font-bold tracking-wide uppercase group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75V15m6-6v8.25m.503 3.498 4.875-2.437c.381-.19.622-.58.622-1.006V4.82c0-.836-.88-1.38-1.628-1.006l-3.869 1.934c-.317.159-.69.159-1.006 0L9.503 3.252a1.125 1.125 0 0 0-1.006 0L3.622 5.689C3.24 5.88 3 6.27 3 6.695V19.18c0 .836.88 1.38 1.628 1.006l3.869-1.934c.317-.159.69-.159 1.006 0l4.994 2.497c.317.158.69.158 1.006 0Z" />
                </svg>
                <span>Map</span>
            </a>
            
            <a href="#about-eduforest" class="flex items-center gap-3 py-3 px-4 rounded-xl text-stone-100 hover:bg-white/10 transition text-xs font-bold tracking-wide uppercase group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 1 1 1.063 1.063l-.3-.311m-.041.02a.75.75 0 0 1-1.063-1.063l.3.311m0 0a3 3 0 1 1 3-3-3 3 0 0 1-3 3Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>About</span>
            </a>
            
            <a href="{{ route('my-bookings') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-stone-100 hover:bg-white/10 transition text-xs font-bold tracking-wide uppercase group">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 opacity-80 group-hover:opacity-100">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span>My Booking</span>
            </a>
            
            <!-- EMERGENCI EMORY KEKAL 🚨 -->
            <a href="{{ route('emergency') }}" class="flex items-center gap-3 py-3 px-4 rounded-xl text-amber-300 hover:bg-white/10 transition text-xs font-bold tracking-wide uppercase animate-pulse">
                <span class="text-sm">🚨</span>
                <span>SOS Call</span>
            </a>
        </nav>
    </div>

    <!-- Bahagian bawah kosong sepenuhnya supaya selamat dan kemas -->
    <div class="p-4 mb-2"></div>
</aside>