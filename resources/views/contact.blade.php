<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EduForest UCTC</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-stone-100 min-h-screen flex flex-col antialiased">

    <!-- Header / Nav Khas Mengikut image_9b2ec1.png & image_9b2f9b.png -->
    <nav class="bg-[#2D5A27] text-white shadow-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center relative justify-center">
            
            <!-- Butang Kembali Bulat Mengikut Tepat Reka Bentuk image_9b2f9b.png -->
            <a href="{{ route('dashboard') }}" class="absolute left-6 inline-flex items-center justify-center w-12 h-12 rounded-full bg-white/10 hover:bg-white/25 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>

            <!-- Tajuk Utama -->
            <h1 class="text-xl font-bold uppercase tracking-wider">CONTACT US</h1>
        </div>
    </nav>

    <!-- Kandungan Utama Mengikut Susunan Bersih image_9b3283.png -->
    <main class="flex-grow max-w-xl w-full mx-auto px-6 py-12">
        
        <!-- Info Hubungan Atas UCTC -->
        <div class="text-center mb-10 text-stone-800">
            <h2 class="font-extrabold text-sm tracking-wide">
                Pusat Transformasi Komuniti Universiti (UCTC)
            </h2>
            <div class="text-xs text-stone-600 mt-2 space-y-0.5">
                <p>05-4506979</p>
                <p>uctc@upsi.edu.my</p>
            </div>
        </div>

        <!-- Senarai Kad Kakitangan (Clear Line Style) -->
        <div class="space-y-6">

            <!-- Kad 1: DR. AQIL WONG -->
            <div class="bg-white border border-stone-300 rounded-2xl p-6 shadow-xs">
                <div class="border-b border-stone-400 pb-2 mb-3">
                    <h3 class="font-bold text-stone-900 text-lg tracking-wide uppercase">
                        DR. AQIL WONG
                    </h3>
                </div>
                <div class="text-right space-y-0.5 text-xs text-stone-600">
                    <p>Deputy Director</p>
                    <p>+6012-5151268</p>
                    <p>cheetah@fsmt.upsi.edu.my</p>
                    <p class="text-stone-500 pt-1">Pusat Transformasi dan Komuniti UCTC, UPSI</p>
                </div>
            </div>

            <!-- Kad 2: ENCIK MOHD ZAIHAM IZWAN -->
            <div class="bg-white border border-stone-300 rounded-2xl p-6 shadow-xs">
                <div class="border-b border-stone-400 pb-2 mb-3">
                    <h3 class="font-bold text-stone-900 text-lg tracking-wide uppercase">
                        ENCIK MOHD ZAIHAM IZWAN
                    </h3>
                </div>
                <div class="text-right space-y-0.5 text-xs text-stone-600">
                    <p>Senior Assistant Registrar N44</p>
                    <p>+605-4505202</p>
                    <p>zaiham_izwan@upsi.edu.my</p>
                    <p class="text-stone-500 pt-1">Pusat Transformasi dan Komuniti UCTC, UPSI</p>
                </div>
            </div>

            <!-- Kad 3: ENCIK AMIN -->
            <div class="bg-white border border-stone-300 rounded-2xl p-6 shadow-xs">
                <div class="border-b border-stone-400 pb-2 mb-3">
                    <h3 class="font-bold text-stone-900 text-lg tracking-wide uppercase">
                        ENCIK AMIN
                    </h3>
                </div>
                <div class="text-right space-y-0.5 text-xs text-stone-600">
                    <p>General Officer</p>
                    <p>+6012-3456789</p>
                    <p>amin.upsi@gmail.com</p>
                    <p class="text-stone-500 pt-1">Pusat Transformasi dan Komuniti UCTC, UPSI</p>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer Ringkas -->
    <footer class="bg-stone-200 text-center py-4 text-[11px] text-stone-400 border-t border-stone-300 mt-auto">
        &copy; {{ date('Y') }} EduForest UCTC UPSI.
    </footer>

</body>
</html>