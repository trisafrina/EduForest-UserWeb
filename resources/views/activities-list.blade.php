<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForest - Senarai Aktiviti</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased min-h-screen pb-12 relative bg-stone-800">

    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1200&q=80" 
            class="w-full h-full object-cover opacity-55 filter blur-xs" alt="Forest Background">
    </div>

    <div class="relative z-10">
        <header class="bg-[#2d5a43]/95 backdrop-blur-md text-white shadow-md sticky top-0 z-50">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between relative">
                <div class="flex items-center gap-3 w-full justify-center">
                    <a href="javascript:history.back()" class="w-10 h-10 flex items-center justify-center rounded-full bg-white/15 hover:bg-white/25 transition-all absolute left-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </a>
                    <h1 class="text-lg font-bold tracking-wide text-center">Activities</h1>
                </div>
            </div>
        </header>

        <main class="max-w-6xl mx-auto px-6 mt-10">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                @forelse($activities as $activity)
                    <a href="{{ route('activity.detail', $activity->id) }}" 
                    class="bg-white rounded-[2rem] p-5 shadow-2xl flex flex-col justify-between border border-gray-100 hover:shadow-emerald-900/20 transition-all duration-300 group cursor-pointer">
                        
                        <div>
                            <div class="relative h-52 rounded-[1.5rem] overflow-hidden bg-gray-100">
                            <img src="{{ is_array($activity->image_urls) ? ($activity->image_urls[0] ?? '') : trim(explode(',', $activity->image_urls)[0]) }}" 
     class="w-full h-full object-cover transition-all duration-300 group-hover:blur-sm group-hover:scale-105" 
     alt="{{ $activity->name }}">
                                
                                <div class="absolute top-3 left-3 bg-black/40 backdrop-blur-md text-white text-[11px] font-bold px-2.5 py-1 rounded-full flex items-center gap-1">
                                    <span class="text-amber-400 text-xs">★</span> 4.9
                                </div>

                                <div class="absolute top-3 right-3 w-8 h-8 rounded-full bg-black/40 backdrop-blur-md flex items-center justify-center text-white group-hover:text-red-400 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </div>

                                <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity duration-300">
                                    <span class="bg-white/20 backdrop-blur-md text-white font-bold text-xs py-2 px-4 rounded-xl border border-white/30 shadow-md tracking-wider">
                                        See Activities
                                    </span>
                                </div>
                            </div>

                            <div class="mt-4 pb-2">
                                <h3 class="text-base font-bold text-gray-900 tracking-tight group-hover:text-[#2d5a43] transition-colors duration-200">
                                    {{ $activity->name }}
                                </h3>
                                <p class="text-xs text-gray-500 mt-1 line-clamp-3 leading-relaxed">
                                    {{ $activity->description ?? 'Teroka keindahan modul alam semula jadi bersama kami.' }}
                                </p>
                            </div>
                        </div>

                    </a>
                @empty
                    <div class="col-span-3 text-center py-16 bg-white rounded-[2rem] shadow-xl">
                        <p class="text-gray-400 text-sm font-medium">Tiada sebarang modul aktiviti ditemui.</p>
                    </div>
                @endforelse

            </div>
        </main>
    </div>

</body>
</html>