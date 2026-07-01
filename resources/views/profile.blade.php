<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-stone-50 via-white to-emerald-50 antialiased">

    <nav class="bg-[#2D5A27] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between relative">
            
            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/10 hover:bg-white/25 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>

            <h1 class="text-lg font-semibold tracking-wide text-white absolute left-1/2 transform -translate-x-1/2">My Profile</h1>

            <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-full text-white hover:bg-white/10 transition" title="Edit Profile">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
            </a>
        </div>
    </nav>

    <main class="max-w-xl w-full mx-auto px-6 py-10">
        
        <div class="bg-white border border-stone-200 rounded-3xl p-8 shadow-xs">
            
            <div class="flex flex-col items-center border-b border-stone-100 pb-6 mb-6">
                <div class="w-20 h-20 rounded-full bg-stone-100 border border-stone-200 text-stone-400 flex items-center justify-center mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <h2 class="text-lg font-bold text-stone-950">{{ $profile->full_name }}</h2>
                <p class="text-xs text-stone-400 font-medium">{{ Auth::user()->email }}</p>
            </div>

            <div class="space-y-6">
                
                <div>
                    <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Full Name</label>
                    <p class="text-sm font-semibold text-stone-800 mt-1">{{ $profile->full_name }}</p>
                </div>

                <div>
                    <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Phone Number</label>
                    <p class="text-sm font-semibold text-stone-800 mt-1">{{ $profile->phone_number }}</p>
                </div>

                <div>
                    <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">User Category</label>
                    <p class="text-sm font-semibold text-stone-800 mt-1">
                        @if($profile->user_category === 'upsi_community')
                            UPSI Community
                        @elseif($profile->user_category === 'government_agency')
                            Government Agency
                        @else
                            {{ ucfirst($profile->user_category) }}
                        @endif
                    </p>
                </div>

                <div>
                    <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Origin / Organization</label>
                    <p class="text-sm font-semibold text-stone-800 mt-1">{{ $profile->origin }}</p>
                </div>

            </div>

        </div>

    </main>

</body>
</html>