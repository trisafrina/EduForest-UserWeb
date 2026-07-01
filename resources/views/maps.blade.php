<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForest - Lokasi Peta</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;500;600;700;800&display=swap');
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="antialiased min-h-screen pb-12 relative bg-stone-900">

    <!-- GAMBAR LATAR BELAKANG HUTAN + KESAN KABUR (BLUR) -->
    <div class="absolute inset-0 z-0">
        <img src="https://images.unsplash.com/photo-1448375240586-882707db888b?auto=format&fit=crop&w=1200&q=80" 
            class="w-full h-full object-cover opacity-40 filter blur-xs" alt="Forest Background">
    </div>

    <!-- SEMUA KANDUNGAN DIBAWAH KENA LETAK z-10 SUPAYA DUDUK DI ATAS BACKGROUND -->
    <div class="relative z-10">
        
        <!-- Header Navigation (Ditambah bg-opacity & backdrop-blur supaya nampak kaca/transparan sikit) -->
        <header class="bg-[#2d5a43]/90 backdrop-blur-md text-white shadow-sm max-w-[100%] mx-auto sticky top-0 z-50">
            <div class="w-full px-6 py-4 flex items-center relative min-h-[60px]">
                <a href="javascript:history.back()" class="absolute left-6 w-10 h-10 flex items-center justify-center rounded-full bg-white/15 hover:bg-white/25 backdrop-blur-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                </a>
                <div class="w-full text-center">
                    <h1 class="text-base font-bold tracking-wide text-white inline-block">Lokasi Edu-Forest</h1>
                </div>
            </div>
        </header>

        <!-- Main Card Container (Ditambah backdrop-blur halus pada kad putih supaya nampak menyatu dengan latar belakang hutan) -->
        <main class="max-w-2xl mx-auto px-4 mt-6">
            <div class="bg-white/95 backdrop-blur-md rounded-3xl p-5 shadow-xl border border-white/20 space-y-5">
                
                <div class="bg-[#d2e7d6] rounded-2xl p-5 flex items-start gap-4">
                    <div class="bg-[#2d5a43] text-white p-3 rounded-xl shrink-0 mt-0.5">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </div>
                    <div class="space-y-1">
                        <h2 class="text-sm font-bold text-[#1a4329]">Edu-Forest UCTC UPSI (Sungai Dara)</h2>
                        <p class="text-xs text-gray-700 leading-relaxed">
                            Kampus Sultan Azlan Shah, 35900 Tanjong Malim, Perak, Malaysia.
                        </p>
                    </div>
                </div>

                <!-- Kotak Live Google Maps -->
                <div class="w-full h-[380px] rounded-2xl overflow-hidden border border-gray-200 shadow-md relative bg-gray-100">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3187.958623214886!2d101.52293927371711!3d3.796976848831503!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cb8f5cff5a1051%3A0xecb8543b3d60e995!2sSungai%20Dara!5e1!3m2!1sen!2smy!4v1782443503015!5m2!1sen!2smy" 
                        class="w-full h-full border-0"
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="strict-origin-when-cross-origin">
                    </iframe>
                </div>

                <!-- Butang Navigasi Gps -->
                <div class="flex gap-3">
                    <a href="https://maps.google.com/?q=Sungai+Dara+Tanjong+Malim" target="_blank" 
                    class="flex-1 bg-[#2d5a43] hover:bg-[#1e3522] text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all text-center tracking-wide text-xs flex items-center justify-center gap-2 cursor-pointer">
                    Buka Google Maps
                    </a>
                    <a href="https://waze.com/ul?q=Sungai+Dara+Tanjong+Malim" target="_blank" 
                    class="flex-1 bg-[#2574a9] hover:bg-[#1b557a] text-white font-bold py-3 px-4 rounded-xl shadow-md transition-all text-center tracking-wide text-xs flex items-center justify-center gap-2 cursor-pointer">
                    Pandu dengan Waze
                    </a>
                </div>

            </div>
        </main>
    </div>

</body>
</html>