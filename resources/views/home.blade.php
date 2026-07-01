<!-- 🟢 SAYA TAMBAH DISINI: Blok PHP untuk ambil data profil pengguna secara dinamik daripada table profiles Supabase -->
@php
    $homeProfile = DB::table('profiles')->where('id', Auth::id())->first();
    $userFullName = $homeProfile->full_name ?? (Auth::check() ? Auth::user()->name : 'Guest');
    $profilePic = $homeProfile->profile_image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($userFullName) . '&background=355E3B&color=fff';
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - EduForest Booking System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght=400;500;600;700;800&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>
<body class="bg-stone-100 m-0 p-0 antialiased min-h-screen flex flex-col justify-between">
    <body ...>
    @include('profile.partials.sidebar')
    <div id="contentWrapper" class="flex-1 pl-68 min-h-screen flex flex-col transition-all duration-300">
        @include('profile.partials.topbar')
        <main class="flex-1">
        </main>
    </div>
    @include('profile.partials.toggle-script')

    <!-- 1. HEADER DENGAN GAYA CURVE APPS (Tiru bahagian atas skrin telefon) -->
    <header class="bg-[#2d5a3c] text-white rounded-b-[40px] shadow-lg pb-10 pt-6 px-8 transition-all">
        <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            
            <!-- Profil Ringkas User + BUTANG BACK KE DASHBOARD -->
            <div class="flex items-center space-x-4">
                
                <!-- ====== SUB-BUTANG BACK MENGGUNAKAN TAILWIND ====== -->
                <a href="{{ route('dashboard') }}" class="p-2.5 bg-white/10 hover:bg-white/20 rounded-full text-white transition-all duration-200 shadow-sm flex items-center justify-center group" title="Kembali ke Dashboard">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <!-- ================================================= -->

                <!-- 🟢 SAYA TUKAR DISINI: Menggantikan bulatan huruf lama kepada paparan Gambar Profil / Avatar Dinamik -->
                <div class="w-14 h-14 rounded-full border-2 border-amber-400 overflow-hidden shadow-md bg-white flex items-center justify-center">
                    <img src="{{ $profilePic }}" class="w-full h-full object-cover" alt="User Profile">
                </div>
                
                <div>
                    <h1 class="text-xs text-stone-300 uppercase tracking-wider font-semibold">Welcome</h1>
                    <p class="text-xl font-bold tracking-tight">Hi {{ $userFullName }},</p>
                </div>
            </div>

            <!-- Senarai Logo Institusi -->
            <div class="bg-white/95 backdrop-blur px-5 py-2 rounded-2xl flex items-center space-x-5 shadow-sm h-14">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/UPSI%20%20LOGO/logo_upsi.png" alt="Logo UPSI" class="h-9 w-auto object-contain">
                
                <div class="h-6 w-px bg-stone-300"></div>
                
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/UCTC%20LOGO/LOGO-UCTC-UPSI.png" alt="Logo UCTC" class="h-9 w-auto object-contain">
                
                <div class="h-6 w-px bg-stone-300"></div>
                
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png" alt="Logo Edu-Forest" class="w-24 md:w-28 h-auto object-contain">
            </div>
        </div>
    </header>

    <!-- 2. KANDUNGAN UTAMA (Layout Web: Kalendar Kiri, Butang Tindakan Kanan) -->
    <main class="max-w-6xl w-full mx-auto px-6 py-12 flex-grow">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            <!-- KIRI (7 Lajur): Fungsi Kalendar Dinamik -->
            <div class="lg:col-span-7 bg-white p-8 rounded-3xl shadow-sm border border-stone-200/60">
                <!-- Header Kalendar -->
                <div class="flex justify-between items-center mb-6">
                    <button onclick="changeMonth(-1)" class="p-2 hover:bg-stone-100 rounded-full cursor-pointer text-stone-600 font-bold">&lt;</button>
                    <h2 id="calendar-month-year" class="text-lg font-bold text-stone-800 uppercase tracking-wide">June 2026</h2>
                    <button onclick="changeMonth(1)" class="p-2 hover:bg-stone-100 rounded-full cursor-pointer text-stone-600 font-bold">&gt;</button>
                </div>

                <!-- Hari-hari dalam seminggu -->
                <div class="grid grid-cols-7 gap-2 text-center text-xs font-bold text-stone-400 uppercase tracking-wider mb-4">
                    <div>Su</div><div>Mo</div><div>Tu</div><div>We</div><div>Th</div><div>Fr</div><div>Sa</div>
                </div>

                <!-- Grid Tarikh (Akan di-render oleh JavaScript) -->
                <div id="calendar-days" class="grid grid-cols-7 gap-3 text-center">
                    <!-- Tarikh dimasukkan secara dinamik di sini -->
                </div>

                <!-- Petunjuk Warna (Legend) -->
                <div class="flex items-center justify-center space-x-6 mt-6 pt-4 border-t border-stone-100 text-xs font-semibold text-stone-500">
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-[#10b981] block rounded-sm"></span>
                        <span>Fully Booked</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-4 h-4 bg-[#dc2626] block rounded-sm"></span>
                        <span>Public Holiday</span>
                    </div>
                </div>
            </div>

            <!-- KANAN (5 Lajur): Dua Butang Utama Sahaja -->
            <div class="lg:col-span-5 flex flex-col space-y-6 h-full justify-center lg:pt-10">
                <div class="bg-stone-50 border border-stone-200 p-6 rounded-2xl text-center">
                    <h3 class="font-bold text-stone-800 uppercase tracking-wide text-sm mb-2">Booking System Slots</h3>
                    <p class="text-xs text-stone-500 leading-relaxed">Please check the calendar on the side. Dates marked in <span class="text-[#10b981] font-bold">Green</span> indicate that the slots are fully booked and confirmed by the administration. Dates marked in <span class="text-[#dc2626] font-bold">Red</span> indicate a public holiday.</p>
                </div>

                <a href="{{ route('activities.list') }}" class="w-full inline-flex items-center justify-center bg-[#2d5a3c] hover:bg-[#244a31] text-white font-bold py-4 px-6 rounded-xl transition duration-200 shadow-sm text-center">
                    Browse Activities
                </a>

                <!-- 2. Butang Booking Now -->
                <a href="{{ route('booking.categories') }}" class="w-full inline-flex items-center justify-center bg-[#2d5a3c] hover:bg-[#244a31] text-white font-bold py-4 px-6 rounded-xl transition duration-200 shadow-sm text-center">
                    Booking Now
                </a>
            </div>

        </div>
    </main>

    <!-- 4. LOGIK JAVASCRIPT UNTUK KALENDAR -->
    <script>
        // 🟢 Data terus dari Supabase (table booking_dates) melalui controller Laravel
        const fullyBookedDates = {!! json_encode($fullyBookedDates ?? []) !!};
        const publicHolidayDates = {!! json_encode($publicHolidayDates ?? []) !!};

        let currentDate = new Date();

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            document.getElementById("calendar-month-year").innerText = `${monthNames[month]} ${year}`;

            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDay = new Date(year, month + 1, 0).getDate();

            const calendarDays = document.getElementById("calendar-days");
            calendarDays.innerHTML = "";

            for (let i = 0; i < firstDayIndex; i++) {
                const emptyDiv = document.createElement("div");
                calendarDays.appendChild(emptyDiv);
            }

            for (let day = 1; day <= lastDay; day++) {
                const dayDiv = document.createElement("div");
                dayDiv.innerText = day;
                dayDiv.className = "py-3 text-sm font-semibold text-stone-700 rounded-xl transition duration-200 ";

                const formattedMonth = String(month + 1).padStart(2, '0');
                const formattedDay = String(day).padStart(2, '0');
                const dateString = `${year}-${formattedMonth}-${formattedDay}`;

                if (publicHolidayDates.includes(dateString)) {
                    dayDiv.className += " bg-[#dc2626] text-white font-bold shadow-sm cursor-not-allowed";
                    dayDiv.title = "Public Holiday";
                } else if (fullyBookedDates.includes(dateString)) {
                    dayDiv.className += " bg-[#10b981] text-white font-bold shadow-sm cursor-not-allowed";
                    dayDiv.title = "Fully Booked (Confirmed by Admin)";
                } else {
                    dayDiv.className += " bg-stone-50 hover:bg-stone-200 cursor-pointer";
                }

                calendarDays.appendChild(dayDiv);
            }
        }

        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        document.addEventListener("DOMContentLoaded", renderCalendar);
    </script>

</body>
</html>