<header class="sticky top-0 z-50 px-4 pt-4">
    <div class="mx-auto max-w-7xl overflow-hidden rounded-[28px] border border-white/60 bg-[#ccebd8]/95 px-6 shadow-[0_18px_55px_rgba(37,83,58,0.18)] backdrop-blur-xl">
        <div class="grid min-h-[82px] grid-cols-3 items-center gap-4">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-4">
                <img src="https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png"
                    class="h-25 w-auto object-contain"
                    alt="EduForest">
                <span class="hidden text-lg font-black uppercase tracking-[0.28em] text-[#1b3045] sm:inline">
                    EduForest
                </span>
            </a>

            <nav class="hidden items-center justify-center gap-2 text-xs font-black uppercase tracking-[0.22em] text-[#1b3045] lg:flex">
                <a href="{{ route('activities.list') }}"
                    class="rounded-full px-5 py-3 transition hover:bg-white/70 {{ request()->routeIs('activities.*') ? 'bg-white text-[#071225] shadow-md' : '' }}">
                    Activities
                </a>

                <a href="{{ route('packages.index') }}"
                    class="rounded-full px-5 py-3 transition hover:bg-white/70 {{ request()->routeIs('packages.*') ? 'bg-white text-[#071225] shadow-md' : '' }}">
                    Packages
                </a>

                <a href="{{ route('maps.index') }}"
                    class="rounded-full px-5 py-3 transition hover:bg-white/70 {{ request()->routeIs('maps.*') ? 'bg-white text-[#071225] shadow-md' : '' }}">
                    Map
                </a>

                <a href="{{ route('booking.categories') }}"
                    class="rounded-full px-5 py-3 transition hover:bg-white/70 {{ request()->routeIs('booking.*') ? 'bg-white text-[#071225] shadow-md' : '' }}">
                    Booking
                </a>

                <a href="{{ route('my-bookings') }}"
                    class="rounded-full px-5 py-3 text-center leading-5 transition hover:bg-white/70 {{ request()->routeIs('my-bookings') ? 'bg-white text-[#071225] shadow-md' : '' }}">
                    My<br>Bookings
                </a>
            </nav>

            <div class="hidden items-center justify-end gap-3 lg:flex">
                <a href="{{ route('profile.show') }}"
                    class="rounded-full px-5 py-3 text-xs font-black uppercase tracking-[0.22em] text-[#1b3045] transition hover:bg-white/70 {{ request()->routeIs('profile.*') ? 'bg-white text-[#071225] shadow-md' : '' }}">
                    Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="rounded-full bg-white px-7 py-3 text-xs font-black uppercase tracking-[0.18em] text-[#1b3045] shadow-md transition hover:bg-[#f7fff9]">
                        Logout
                    </button>
                </form>
            </div>

            <button id="mobileMenuBtn" type="button"
                class="col-start-3 justify-self-end rounded-2xl bg-white/70 p-3 text-[#1b3045] shadow-sm transition hover:bg-white lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>

        <div id="mobileMenu" class="hidden border-t border-white/50 pb-5 pt-3 lg:hidden">
            <nav class="space-y-2 text-sm font-black uppercase tracking-[0.16em] text-[#1b3045]">
                <a href="{{ route('activities.list') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/70">Activities</a>
                <a href="{{ route('packages.index') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/70">Packages</a>
                <a href="{{ route('maps.index') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/70">Map</a>
                <a href="{{ route('booking.categories') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/70">Booking</a>
                <a href="{{ route('my-bookings') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/70">My Bookings</a>
                <a href="{{ route('profile.show') }}" class="block rounded-2xl px-4 py-3 transition hover:bg-white/70">Settings</a>

                <form method="POST" action="{{ route('logout') }}" class="pt-2">
                    @csrf
                    <button type="submit"
                        class="w-full rounded-2xl bg-white px-4 py-3 text-center font-black uppercase tracking-[0.16em] text-[#1b3045] shadow-sm">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </div>
</header>

<script>
    document.getElementById('mobileMenuBtn')?.addEventListener('click', function () {
        document.getElementById('mobileMenu')?.classList.toggle('hidden');
    });
</script>