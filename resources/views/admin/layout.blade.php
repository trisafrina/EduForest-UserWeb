<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edu-Forest Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        
        <div class="w-64 bg-[#1E4620] text-white flex flex-col shadow-xl z-10">
            <div class="p-6 text-center font-bold text-lg tracking-wider border-b border-green-900 bg-[#163317]">
                🌳 EDU-FOREST ADMIN
            </div>
            
            <nav class="flex-1 p-4 space-y-2 mt-4">
                
                <a href="{{ route('admin.slots.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.slots.*') ? 'bg-green-800 font-bold' : 'hover:bg-green-800/60 transition font-medium' }}">
                    <span>📅</span> <span>Calendar Availability</span>
                </a>
                
                <a href="{{ route('admin.clients') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.clients') ? 'bg-green-800 font-bold' : 'hover:bg-green-800/60 transition font-medium' }}">
                    <span>👤</span> <span>Registered Clients</span>
                </a>
                
                <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.bookings.*') ? 'bg-green-800 font-bold' : 'hover:bg-green-800/60 transition font-medium' }}">
                    <span>📅</span> <span>Booking Requests</span>
                </a>

                <a href="{{ route('admin.payments.index') }}" class="flex items-center space-x-3 py-3 px-4 rounded-xl {{ request()->routeIs('admin.payments.*') ? 'bg-green-800 font-bold' : 'hover:bg-green-800/60 transition font-medium' }}">
                    <span>💳</span> <span>Verify Payments</span>
                </a>

                <div class="pt-6 border-t border-green-900 mt-6">
                    <a href="/dashboard" class="flex items-center space-x-3 py-2.5 px-4 rounded-xl text-gray-400 hover:text-white transition text-sm">
                        <span>⬅️</span> <span>Back to Main Dashboard</span>
                    </a>
                </div>
            </nav>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white border-b border-gray-200 py-4 px-8 flex justify-between items-center shadow-sm">
                <h1 class="text-xl font-bold text-gray-800">Edu-Forest Control Panel</h1>
                <span class="text-sm bg-green-50 text-green-800 font-semibold py-1 px-3 rounded-full">Admin Mode Active</span>
            </header>
            
            <main class="p-8">
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-600 text-green-900 rounded-r-xl shadow-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>

    </div>
</body>
</html>