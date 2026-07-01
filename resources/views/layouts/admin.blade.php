<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu-Forest Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">
        
        <div class="w-64 bg-[#2d5a3b] text-white flex flex-col shadow-xl">
            <div class="p-5 border-b border-emerald-800 flex items-center space-x-3">
                <div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-[#2d5a3b] font-bold text-xl shadow-md">
                    A
                </div>
                <div>
                    <h4 class="font-bold text-sm tracking-wide">{{ session('admin_name', 'Admin') }}</h4>
                    <span class="text-xs text-emerald-300 flex items-center">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block mr-1 animate-pulse"></span>
                        Administrator
                    </span>
                </div>
            </div>

            <nav class="flex-1 p-4 space-y-2 text-sm font-medium">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800 transition shadow-sm {{ request()->routeIs('dashboard') ? 'bg-emerald-800' : '' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800 transition">
                    <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                    <span>Manage Slots</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800 transition">
                    <i class="fa-solid fa-file-invoice w-5 text-center"></i>
                    <span>Booking Requests</span>
                </a>
                
                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800 transition">
                    <i class="fa-solid fa-receipt w-5 text-center"></i>
                    <span>Verify Payments</span>
                </a>

                <a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-xl hover:bg-emerald-800 transition">
                    <i class="fa-solid fa-users w-5 text-center"></i>
                    <span>User Profiles</span>
                </a>
            </nav>

            <div class="p-4 border-t border-emerald-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 rounded-xl bg-red-700 hover:bg-red-800 text-white font-bold transition text-left shadow-md">
                        <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
                        <span>Log Out</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8 shadow-sm">
                <div class="flex items-center space-x-2">
                    <span class="text-xl font-bold text-gray-800">Edu-Forest</span>
                    <span class="text-xs bg-emerald-100 text-emerald-800 px-2 py-0.5 font-bold rounded-full">Admin Portal</span>
                </div>
                <div class="text-sm text-gray-600 font-medium">
                    {{ now()->format('l, d F Y') }}
                </div>
            </header>

            <main class="p-8 flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>

    </div>

</body>
</html>