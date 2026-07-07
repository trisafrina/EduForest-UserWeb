<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduForest UCTC</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen overflow-x-hidden bg-[#eef8f1] antialiased">

    @php
        $fallbackHeroImages = [
            'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/6170282320066187830.jpg',
            'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/photo_2026-07-02_11-31-42.jpg',
            'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/photo_2026-07-02_11-31-37.jpg',
        ];

        $fallbackAboutImage = 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/ACTIVITIES/DASHBOARD%20BACKGROUND/photo_2026-07-02_11-31-15.jpg';

        $fallbackVideo = 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/videos/eduforest%20video.MOV';

        $homepageMedia = collect();

        try {
            $homepageMedia = DB::table('homepage_media')->get();
        } catch (\Throwable $e) {
            $homepageMedia = collect();
        }

        $getUrl = function ($item) {
            return $item->url
                ?? $item->media_url
                ?? $item->image_url
                ?? $item->video_url
                ?? null;
        };

        $heroImages = $homepageMedia
            ->filter(function ($item) {
                $section = strtolower($item->section ?? '');
                $type = strtolower($item->type ?? '');

                return $section === 'hero' || $type === 'hero' || $type === 'hero_image';
            })
            ->map(fn ($item) => $getUrl($item))
            ->filter()
            ->values()
            ->all();

        if (empty($heroImages)) {
            $heroImages = $fallbackHeroImages;
        }

        $aboutImage = $homepageMedia
            ->filter(function ($item) {
                $section = strtolower($item->section ?? '');
                $type = strtolower($item->type ?? '');

                return $section === 'about' || $type === 'about_image';
            })
            ->map(fn ($item) => $getUrl($item))
            ->filter()
            ->first() ?? $fallbackAboutImage;

        $videoUrl = $homepageMedia
            ->filter(function ($item) {
                $section = strtolower($item->section ?? '');
                $type = strtolower($item->type ?? '');

                return $section === 'video' || $type === 'video';
            })
            ->map(fn ($item) => $getUrl($item))
            ->filter()
            ->first() ?? $fallbackVideo;

        $aboutShort = "Universiti Pendidikan Sultan Idris (UPSI) Edu-Forest is a 10-hectare living laboratory and eco-adventure destination located within the lush Behrang Forest Reserve near Tanjung Malim, on the edge of the magnificent Titiwangsa Range. Developed and managed by UPSI, Edu-Forest combines environmental education, biodiversity conservation, ecotourism, and outdoor recreation in a natural rainforest setting, making it a unique destination for both learning and adventure.";

        $aboutMoreOne = "The area offers immersive nature-based experiences while also featuring stunning natural attractions. Beyond nature exploration, Edu-Forest is also known for its adrenaline-filled activities such as water tubing, jungle trekking, water confident, and many more. As a living lab, the site supports hands-on research and field studies in areas including biology, geography, environmental science, sports science, and ecotourism, providing students and researchers with real-world learning opportunities.";

        $aboutMoreTwo = "Combining education, conservation, research, and adventure tourism, UPSI Edu-Forest serves as a gateway for people to reconnect with nature while promoting environmental awareness and sustainable ecosystem protection.";
    @endphp

    @include('profile.partials.topbar')

    <main class="mx-auto max-w-7xl px-5 pb-16 pt-8 lg:px-8">

        <section class="relative overflow-hidden rounded-[34px] bg-slate-900 shadow-[0_24px_70px_rgba(47,125,79,0.18)]">
            <div id="heroSlider"
                class="relative flex min-h-[430px] items-center overflow-hidden bg-cover bg-center px-8 py-16 transition-all duration-700 lg:min-h-[520px] lg:px-16"
                style="background-image: linear-gradient(90deg, rgba(8,21,14,0.78), rgba(8,21,14,0.34)), url('{{ $heroImages[0] }}');">

                <button type="button" onclick="previousSlide()"
                    class="absolute left-5 top-1/2 z-20 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur transition hover:bg-[#2f7d4f]">
                    ‹
                </button>

                <div class="relative z-10 max-w-xl text-white">
                    <p class="mb-3 text-xs font-extrabold uppercase tracking-[0.28em] text-[#d8f3dc]">
                        Learn. Explore. Discover.
                    </p>

                    <h1 class="text-4xl font-black leading-tight tracking-tight lg:text-6xl">
                        Discover Nature,<br>
                        Adventure and Learning
                    </h1>

                    <p class="mt-5 max-w-lg text-sm font-medium leading-7 text-white/85">
                        Edu-Forest UPSI offers hands-on outdoor experiences that build skills, confidence and a love for nature.
                    </p>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('activities.list') }}"
                            class="rounded-full bg-[#2f7d4f] px-6 py-3 text-xs font-extrabold uppercase tracking-wide text-white shadow-lg transition hover:bg-[#25663f]">
                            Explore Activities
                        </a>

                        <a href="{{ route('booking.categories') }}"
                            class="rounded-full border border-white/70 px-6 py-3 text-xs font-extrabold uppercase tracking-wide text-white transition hover:bg-white hover:text-slate-900">
                            Book Now
                        </a>
                    </div>
                </div>

                <button type="button" onclick="nextSlide()"
                    class="absolute right-5 top-1/2 z-20 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-black/30 text-white backdrop-blur transition hover:bg-[#2f7d4f]">
                    ›
                </button>

                <div id="heroDots" class="absolute bottom-6 left-1/2 z-20 flex -translate-x-1/2 gap-2"></div>
            </div>
        </section>

        <section id="about-eduforest" class="mt-10 grid gap-6 lg:grid-cols-2">
            <div class="rounded-[30px] border border-white/70 bg-white/90 p-8 shadow-[0_20px_60px_rgba(47,125,79,0.12)] lg:p-10">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#2f7d4f]">
                    About Edu-Forest
                </p>

                <h2 class="mt-3 text-3xl font-black uppercase tracking-tight text-slate-950">
                    Where Learning<br>
                    Meets the Wild
                </h2>

                <div class="mt-5 h-1.5 w-14 rounded-full bg-[#046307]"></div>

                <div class="mt-7 space-y-4 text-sm font-medium leading-8 text-slate-600">
                    <p class="text-justify">
                        {{ $aboutShort }}
                    </p>

                    <div id="moreAboutText" class="hidden space-y-4">
                        <p class="text-justify">
                            {{ $aboutMoreOne }}
                        </p>

                        <p class="text-justify">
                            {{ $aboutMoreTwo }}
                        </p>
                    </div>
                </div>

                <button type="button" id="readMoreBtn" onclick="toggleReadMore()"
                    class="mt-7 rounded-full bg-[#2f7d4f] px-6 py-3 text-xs font-extrabold uppercase tracking-widest text-white shadow-md transition hover:bg-[#25663f]">
                    Read More
                </button>
            </div>

            <div class="overflow-hidden rounded-[30px] border border-white/70 bg-white shadow-[0_20px_60px_rgba(47,125,79,0.12)]">
                <img src="{{ $aboutImage }}"
                    alt="EduForest UPSI"
                    class="h-full min-h-[420px] w-full object-cover">
            </div>
        </section>

        <section class="mt-6 grid gap-6 lg:grid-cols-2">
            <div class="group relative overflow-hidden rounded-[30px] border border-white/70 bg-slate-900 shadow-[0_20px_60px_rgba(47,125,79,0.12)]">
                @if($videoUrl)
                    <video class="h-full min-h-[320px] w-full object-cover" controls preload="metadata">
                        <source src="{{ $videoUrl }}">
                    </video>
                @else
                    <img src="{{ $heroImages[0] }}" alt="EduForest video preview" class="h-full min-h-[320px] w-full object-cover opacity-90">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-white text-[#2f7d4f] shadow-xl">
                            <span class="ml-1 text-3xl">▶</span>
                        </div>
                    </div>
                @endif
            </div>

            <div class="relative overflow-hidden rounded-[30px] border border-white/70 bg-white/90 p-8 shadow-[0_20px_60px_rgba(47,125,79,0.12)] lg:p-10">
                <p class="text-xs font-extrabold uppercase tracking-[0.2em] text-[#2f7d4f]">
                    Experience Edu-Forest
                </p>

                <h2 class="mt-3 text-3xl font-black tracking-tight text-slate-950">
                    Adventure. Education.<br>
                    Memories That Last.
                </h2>

                <p class="mt-5 text-sm font-medium leading-8 text-slate-600">
                    Watch how participants experience river crossing, jungle trekking, water confident and more in the heart of the rainforest.
                </p>

                @if($videoUrl)
                    <a href="{{ $videoUrl }}" target="_blank"
                        class="mt-7 inline-flex rounded-full bg-[#2f7d4f] px-6 py-3 text-xs font-extrabold uppercase tracking-widest text-white shadow-md transition hover:bg-[#25663f]">
                        Watch Video
                    </a>
                @else
                    <span class="mt-7 inline-flex rounded-full border border-[#c9ead6] bg-[#eef8f1] px-6 py-3 text-xs font-extrabold uppercase tracking-widest text-[#2f7d4f]">
                        Watch Video
                    </span>
                @endif
            </div>
        </section>

        <section class="mx-auto mt-10 max-w-[1300px] rounded-[28px] bg-white/90 px-8 py-10 shadow-[0_18px_55px_rgba(47,125,79,0.10)]">
    <div class="text-center">
        <h2 class="text-sm font-extrabold uppercase tracking-wide text-[#2f7d4f]">
            Why Choose Edu-Forest
        </h2>
        <div class="mx-auto mt-2 h-1 w-14 rounded-full bg-[#046307]"></div>
    </div>

    <div class="mt-8 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        <div class="text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#eef8f1] text-[#2f7d4f]">
                <span class="text-2xl">🌲</span>
            </div>
            <h3 class="mt-4 text-sm font-extrabold text-slate-900">Natural Rainforest</h3>
            <p class="mt-2 text-xs font-medium leading-5 text-slate-500">
                Protected rainforest rich in biodiversity and natural beauty.
            </p>
        </div>

        <div class="text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#eef8f1] text-[#2f7d4f]">
                <span class="text-2xl">👣</span>
            </div>
            <h3 class="mt-4 text-sm font-extrabold text-slate-900">Certified Instructors</h3>
            <p class="mt-2 text-xs font-medium leading-5 text-slate-500">
                Experienced instructors guiding every outdoor activity.
            </p>
        </div>

        <div class="text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#eef8f1] text-[#2f7d4f]">
                <span class="text-2xl">🛡️</span>
            </div>
            <h3 class="mt-4 text-sm font-extrabold text-slate-900">Safety First</h3>
            <p class="mt-2 text-xs font-medium leading-5 text-slate-500">
                Safety equipment and briefing provided for every activity.
            </p>
        </div>

        <div class="text-center">
            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-[#eef8f1] text-[#2f7d4f]">
                <span class="text-2xl">🎓</span>
            </div>
            <h3 class="mt-4 text-sm font-extrabold text-slate-900">Learning By Doing</h3>
            <p class="mt-2 text-xs font-medium leading-5 text-slate-500">
                Hands-on learning that builds skills and confidence.
            </p>
        </div>
    </div>
</section>

<section class="mx-auto mt-8 max-w-[1300px] rounded-[28px] bg-white/90 px-8 py-10 shadow-[0_18px_55px_rgba(47,125,79,0.10)]">
    <div class="text-center">
        <h2 class="text-sm font-extrabold uppercase tracking-wide text-[#2f7d4f]">
            What Participants Say
        </h2>
        <div class="mx-auto mt-2 h-1 w-14 rounded-full bg-[#046307]"></div>
    </div>

    <div class="mt-8 grid gap-6 md:grid-cols-2">
        <div class="rounded-3xl border border-[#d8f3dc] bg-white p-6 shadow-sm">
    <div class="text-amber-400">★★★★★</div>
    <p class="mt-3 text-sm font-medium leading-7 text-slate-600">
        “Amazing experience! The instructors were great and the activities were well organized.”
    </p>
    <div class="mt-5 flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#eef8f1] text-sm font-extrabold text-[#2f7d4f]">
            AH
        </div>
        <div>
            <p class="text-sm font-extrabold text-slate-900">Aiman Hakim</p>
            <p class="text-xs font-medium text-slate-400">UPSI Student</p>
        </div>
    </div>
</div>

<div class="rounded-3xl border border-[#d8f3dc] bg-white p-6 shadow-sm">
    <div class="text-amber-400">★★★★★</div>
    <p class="mt-3 text-sm font-medium leading-7 text-slate-600">
        “A perfect place for outdoor learning and team building. Highly recommended!”
    </p>
    <div class="mt-5 flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#eef8f1] text-sm font-extrabold text-[#2f7d4f]">
            NA
        </div>
        <div>
            <p class="text-sm font-extrabold text-slate-900">Nur Alisyah</p>
            <p class="text-xs font-medium text-slate-400">Teacher</p>
        </div>
    </div>
</div>

<div class="rounded-3xl border border-[#d8f3dc] bg-white p-6 shadow-sm">
    <div class="text-amber-400">★★★★★</div>
    <p class="mt-3 text-sm font-medium leading-7 text-slate-600">
        “The activities helped our students learn teamwork, confidence and safety in nature.”
    </p>
    <div class="mt-5 flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#eef8f1] text-sm font-extrabold text-[#2f7d4f]">
            SR
        </div>
        <div>
            <p class="text-sm font-extrabold text-slate-900">Siti Rohani</p>
            <p class="text-xs font-medium text-slate-400">Program Coordinator</p>
        </div>
    </div>
</div>

<div class="rounded-3xl border border-[#d8f3dc] bg-white p-6 shadow-sm">
    <div class="text-amber-400">★★★★★</div>
    <p class="mt-3 text-sm font-medium leading-7 text-slate-600">
        “Edu-Forest is calm, beautiful and exciting. The river activities were the best part.”
    </p>
    <div class="mt-5 flex items-center gap-3">
        <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#eef8f1] text-sm font-extrabold text-[#2f7d4f]">
            MF
        </div>
        <div>
            <p class="text-sm font-extrabold text-slate-900">Muhammad Faris</p>
            <p class="text-xs font-medium text-slate-400">Visitor</p>
        </div>
    </div>
</div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-6 pb-16">
    <div class="flex justify-center">
        <button type="button" onclick="openProjectInfoModal()"
            class="rounded-full bg-[#2d6a4f] px-8 py-4 text-sm font-extrabold uppercase tracking-[0.18em] text-white shadow-[0_18px_40px_rgba(45,106,79,0.28)] transition hover:-translate-y-0.5 hover:bg-[#24563f]">
            About This Project
        </button>
    </div>
</section>

<div id="projectInfoModal"
    class="fixed inset-0 z-[9999] hidden items-center justify-center bg-slate-950/45 px-5 py-8 backdrop-blur-sm">
    <div class="relative max-h-[90vh] w-full max-w-4xl overflow-y-auto rounded-[32px] bg-white p-8 shadow-[0_30px_90px_rgba(15,23,42,0.25)] md:p-10">
        <button type="button" onclick="closeProjectInfoModal()"
            class="absolute right-5 top-5 flex h-11 w-11 items-center justify-center rounded-full bg-[#edf7f1] text-2xl font-bold text-[#2d6a4f] transition hover:bg-[#d8efe2]">
            &times;
        </button>

        <p class="text-xs font-extrabold uppercase tracking-[0.22em] text-[#2d6a4f]">Apps Info</p>
        <h2 class="mt-3 text-3xl font-black text-[#07111f]">About This Project</h2>
        <div class="mt-4 h-2 w-20 rounded-full bg-[#0b6b1b]"></div>

        <div class="mt-8 space-y-5 text-[15px] leading-8 text-slate-600">
            <div class="rounded-3xl border border-[#d8efe2] bg-[#f4fbf7] p-5">
                <h3 class="text-lg font-extrabold text-[#2d6a4f]">Project Overview</h3>
                <p class="mt-2">
                    Edu-Forest Booking Management System (EFBMS) is a web-based system developed to improve the booking process at Edu-Forest Adventures, an eco-tourism destination managed by UPSI. The system provides an online platform that enables visitors to browse activity packages, check availability, and make bookings conveniently, while allowing administrators to manage bookings and customer records more efficiently.
                </p>
                <p class="mt-4">
                    The system is developed using modern web technologies to provide a user-friendly interface for both visitors and administrators. By digitizing the booking process, EFBMS is expected to improve communication between customers and the management while enhancing the overall efficiency of booking operations.
                </p>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-slate-400">Subject</p>
                    <p class="mt-2 font-bold text-[#07111f]">DTD 3053</p>
                    <p class="text-slate-500">Web Programming for Information System</p>
                </div>

                <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                    <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-slate-400">Lecturer</p>
                    <p class="mt-2 font-bold text-[#07111f]">Profesor Madya Dr. Aslina binti Saad</p>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                <p class="text-xs font-extrabold uppercase tracking-[0.16em] text-slate-400">Team Members</p>
                <ul class="mt-3 space-y-2 font-bold text-[#07111f]">
                    <li>AFRINA BATRISYIA BINTI NOR AZLI (D20231106467)</li>
                    <li>AZWALEZA BINTI AZLAN (D20231106532)</li>
                    <li>HUMAIRAH QAIREENA BINTI ABDULLAH (D20231106526)</li>
                </ul>
            </div>

            <div class="rounded-3xl border border-[#d8efe2] bg-[#f4fbf7] p-6 text-center">
                <p class="text-sm font-extrabold uppercase tracking-[0.14em] text-[#2d6a4f]">Faculty</p>
                <p class="mt-2 text-lg font-black text-[#07111f]">Faculty Computing and Meta Technology</p>
                <p class="mt-3 text-sm font-bold text-[#2d6a4f]">Copyright @ Faculty Computing and Meta Technology</p>
            </div>
        </div>
    </div>
</div>

<script>
    function openProjectInfoModal() {
        const modal = document.getElementById('projectInfoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeProjectInfoModal() {
        const modal = document.getElementById('projectInfoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProjectInfoModal();
        }
    });

    document.getElementById('projectInfoModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeProjectInfoModal();
        }
    });
</script>

    </main>

    <script>
        const heroImages = @json($heroImages);
        let currentSlide = 0;
        const heroSlider = document.getElementById('heroSlider');
        const heroDots = document.getElementById('heroDots');

        function renderDots() {
            if (!heroDots) return;

            heroDots.innerHTML = heroImages.map((_, index) => `
                <button type="button"
                    onclick="goToSlide(${index})"
                    class="h-2.5 rounded-full transition ${index === currentSlide ? 'w-8 bg-white' : 'w-2.5 bg-white/45'}">
                </button>
            `).join('');
        }

        function showSlide(index) {
            if (!heroSlider || !heroImages.length) return;

            currentSlide = index;
            heroSlider.style.backgroundImage =
                `linear-gradient(90deg, rgba(8,21,14,0.78), rgba(8,21,14,0.34)), url('${heroImages[currentSlide]}')`;

            renderDots();
        }

        function nextSlide() {
            showSlide((currentSlide + 1) % heroImages.length);
        }

        function previousSlide() {
            showSlide((currentSlide - 1 + heroImages.length) % heroImages.length);
        }

        function goToSlide(index) {
            showSlide(index);
        }

        function toggleReadMore() {
            const content = document.getElementById('moreAboutText');
            const button = document.getElementById('readMoreBtn');

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                button.textContent = 'Read Less';
            } else {
                content.classList.add('hidden');
                button.textContent = 'Read More';
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            showSlide(0);

            if (heroImages.length > 1) {
                setInterval(nextSlide, 4500);
            }
        });
    </script>

<script>
    function openProjectInfo() {
        const modal = document.getElementById('projectInfoModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeProjectInfo() {
        const modal = document.getElementById('projectInfoModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeProjectInfo();
        }
    });

    document.getElementById('projectInfoModal').addEventListener('click', function(event) {
        if (event.target === this) {
            closeProjectInfo();
        }
    });
</script>
</body>
</html>