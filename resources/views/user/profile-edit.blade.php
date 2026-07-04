<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>

<body class="bg-gradient-to-br from-stone-50 via-white to-emerald-50 antialiased">

    @include('profile.partials.topbar')

    @php
        $nameParts = collect(explode(' ', trim($profile->full_name ?? 'User')))->filter()->values();
        $initials = strtoupper(substr($nameParts->first() ?? 'U', 0, 1) . substr($nameParts->get(1, ''), 0, 1));

        if (strlen($initials) < 2) {
            $initials = strtoupper(substr($profile->full_name ?? 'US', 0, 2));
        }
    @endphp

    <div class="max-w-xl w-full mx-auto px-6 pt-10 text-center">
        <h1 class="text-xl font-semibold tracking-wide text-stone-800">Edit Profile</h1>
    </div>

    <main class="max-w-xl w-full mx-auto px-6 py-10">
        <div class="bg-white border border-stone-200 rounded-3xl p-6 shadow-xs">

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">

                    <div class="flex flex-col items-center border-b border-stone-100 pb-5 mb-2">
                        <div class="flex h-24 w-24 items-center justify-center rounded-full border-2 border-stone-200 bg-stone-100 text-4xl font-medium uppercase text-stone-400 shadow-sm">
                            {{ $initials }}
                        </div>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Full Name</label>
                        <input
                            type="text"
                            name="full_name"
                            value="{{ old('full_name', $profile->full_name) }}"
                            class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Phone Number</label>
                        <input
                            type="text"
                            name="phone_number"
                            value="{{ old('phone_number', $profile->phone_number) }}"
                            class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition"
                            required
                        >
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">User Category</label>
                        <select
                            name="user_category"
                            class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition"
                            required
                        >
                            <option value="upsi_community" {{ $profile->user_category == 'upsi_community' ? 'selected' : '' }}>UPSI Community</option>
                            <option value="government_agency" {{ $profile->user_category == 'government_agency' ? 'selected' : '' }}>Government Agency</option>
                            <option value="public" {{ $profile->user_category == 'public' ? 'selected' : '' }}>Public / Individual</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold tracking-wider text-stone-400 uppercase">Origin / Organization</label>
                        <input
                            type="text"
                            name="origin"
                            value="{{ old('origin', $profile->origin) }}"
                            class="w-full mt-1.5 px-4 py-3 bg-stone-50 border border-stone-200 rounded-xl text-sm font-medium text-stone-800 focus:outline-none focus:border-[#2D5A27] focus:bg-white transition"
                            required
                        >
                    </div>

                    <div class="pt-4">
                        <button
                            type="submit"
                            class="w-full py-4 bg-[#2D5A27] hover:bg-[#22441D] text-white font-bold text-sm rounded-xl transition shadow-md tracking-wide uppercase cursor-pointer"
                        >
                            Save Changes
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </main>

</body>
</html>