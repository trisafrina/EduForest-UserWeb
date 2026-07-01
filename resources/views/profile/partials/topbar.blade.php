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