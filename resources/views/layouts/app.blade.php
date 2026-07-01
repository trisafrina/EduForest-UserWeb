<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

<<<<<<< HEAD
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
=======
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900 bg-gray-50">
        
        <div class="min-h-screen flex" x-data="{ sidebarOpen: true }">
            
            <aside class="fixed inset-y-0 left-0 z-50 flex flex-col justify-between w-64 p-6 bg-[#1e4634] text-white transition-transform duration-300 transform shadow-xl overflow-y-auto"
                :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
                
                <div>
                    <div class="flex items-center gap-3 pb-6 border-b border-white/10">
                        <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png" alt="EduForest Logo" class="w-10 h-10 border border-white/20 rounded-full bg-white p-0.5">
                        <h3 class="text-base font-bold tracking-wider text-white">Edu-Forest UPSI</h3>
                    </div>

                    <div class="flex items-center gap-3 py-6">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-white/10 border border-white/20 flex-shrink-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=ffffff&color=2d5a43" class="w-full h-full object-cover" alt="Avatar">
                        </div>
                        <div class="overflow-hidden">
                            <h4 class="font-bold text-white text-xs truncate leading-tight">{{ Auth::user()->name ?? 'Guest User' }}</h4>
                            <p class="text-[10px] text-white/60 truncate mt-0.5">@<span>{{ Str::slug(Auth::user()->name ?? 'user', '') }}</span></p>
                        </div>
                    </div>

                    <nav class="space-y-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-4 py-3 px-3 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition font-semibold text-xs group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-white/60 group-hover:text-white transition">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            Profile
                        </a>

                        <a href="{{ route('my-bookings') }}" class="flex items-center gap-4 py-3 px-3 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition font-semibold text-xs group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-white/60 group-hover:text-white transition">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.03 0 1.9.693 2.166 1.638m-7.377 0A48.536 48.536 0 0 1 12 3m0 0c-2.917 0-5.747.294-8.5.862m24 0a48.394 48.394 0 0 0-2.2-.032M3 3.862v14.052c0 1.135.845 2.098 1.976 2.192a48.423 48.423 0 0 0 1.123.08M3 3.862a48.41 48.41 0 0 1 8.5-.862m0 0a48.394 48.394 0 0 1 2.2-.032" />
                            </svg>
                            My Booking
                        </a>

                        <a href="#" class="flex items-center gap-4 py-3 px-3 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition font-semibold text-xs group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-white/60 group-hover:text-white transition">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            Notifications
                        </a>

                        <a href="#" class="flex items-center gap-4 py-3 px-3 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition font-semibold text-xs group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-white/60 group-hover:text-white transition">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.824-1.802-5.124-4.101-7.927-6.928l1.293-.97.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            Contact Us
                        </a>

                        <a href="#" class="flex items-center gap-4 py-3 px-3 rounded-xl text-white/80 hover:bg-white/10 hover:text-white transition font-semibold text-xs group">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-white/60 group-hover:text-white transition">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 1 1 1.063 1.062 1.25 1.25 0 1 0-1.104 2.124m.02-.021a.749.749 0 1 1 .012-1.498m-.012 1.498h.007M12 22.5c5.385 0 9.75-4.365 9.75-9.75s-4.365-9.75-9.75-9.75S2.25 7.135 2.25 12s4.365 9.75 9.75 9.75Z" />
                            </svg>
                            Help & Support
                        </a>
                    </nav>
                </div>

                <div class="pt-4 border-t border-white/10">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full py-2.5 text-center bg-red-600 hover:bg-red-700 text-white font-bold text-xs rounded-xl transition cursor-pointer">
                            Logout
                        </button>
                    </form>
                </div>
            </aside>

            <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/40 z-40 lg:hidden" style="display: none;"></div>

            <div class="flex-1 flex flex-col min-w-0 transition-all duration-300"
                :class="sidebarOpen ? 'lg:pl-64' : 'lg:pl-0'">
                
                <header class="bg-[#2d6a4f] h-16 flex items-center justify-between px-6 shadow-sm sticky top-0 z-30">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:bg-white/10 p-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                            </svg>
                        </button>
                        <h2 class="text-white font-bold text-base tracking-wide">System Portal</h2>
                    </div>

                    <div class="text-white text-xs font-semibold bg-white/15 px-4 py-2 rounded-full border border-white/10">
                        {{ Auth::user()->name ?? 'User' }}
                    </div>
                </header>

                @isset($header)
                    <div class="bg-white border-b border-gray-100 py-4 px-6">
                        <div class="mx-auto">
                            {{ $header }}
                        </div>
                    </div>
                @endisset

                <main class="flex-1 p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>

        </div>
    </body>
</html>
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
