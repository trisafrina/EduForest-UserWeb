@php
    $formatList = function ($value) {
        $decoded = json_decode($value ?? '', true);

        if (is_array($decoded)) {
            return collect($decoded)->filter()->values()->all();
        }

        return collect(explode(',', $value ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();
    };

    $getImage = function ($package) {
        $rawImages = $package->image_urls ?? $package->image_url ?? $package->image ?? '';
        $decoded = json_decode($rawImages, true);

        if (is_array($decoded)) {
            $image = collect($decoded)->filter()->first();
        } else {
            $image = collect(explode(',', $rawImages))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->first();
        }

        return $image ?: 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png';
    };

    $categories = [
        [
            'slug' => 'upsi',
            'name' => 'UPSI Community',
            'description' => 'Special package for Universiti Pendidikan Sultan Idris members.',
            'price_label' => 'From RM 40 / person',
            'image_url' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/UPSI%20COMMUNITY/upsi%20community.jpg',
        ],
        [
            'slug' => 'gov',
            'name' => 'Government Agency',
            'description' => 'Package for government agencies and statutory bodies.',
            'price_label' => 'From RM 60 / person',
            'image_url' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/GOVERNMENT%20AGENCIES/government.gif',
        ],
        [
            'slug' => 'public',
            'name' => 'Public',
            'description' => 'Package for public participants.',
            'price_label' => 'From RM 80 / person',
            'image_url' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/PUBLIC/public.webp',
        ],
        [
            'slug' => 'international',
            'name' => 'International',
            'description' => 'Package for international participants.',
            'price_label' => 'From USD 36 / person',
            'image_url' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/INTERNATIONAL/international.png',
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForest - Packages</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[#eef8f1] antialiased overflow-x-hidden">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,#d8f3dc_0,#eef8f1_34%,#f8fbf7_72%)]">
        @include('profile.partials.topbar')

        <main class="mx-auto max-w-7xl px-5 py-10 lg:px-8">
            <section>
                <div class="mb-5">
                    <h2 class="text-lg font-extrabold uppercase tracking-wide text-[#000000]">
                        1. Select Category
                    </h2>
                    <p class="mt-1 text-sm font-medium text-slate-500">
                        Choose a participant category to see available package pricing.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                    @foreach($categories as $category)
                        @php
                            $isActive = $categoryInput === $category['slug'];
                        @endphp

                        <a href="{{ route('packages.index', ['category' => $category['slug']]) }}"
                            class="flex min-h-[280px] flex-col overflow-hidden rounded-3xl border bg-white/80 text-center shadow-[0_14px_40px_rgba(62,111,82,0.10)] backdrop-blur-xl transition hover:-translate-y-0.5 hover:shadow-[0_18px_50px_rgba(62,111,82,0.16)] {{ $isActive ? 'border-[#6ba982] ring-2 ring-[#c9ead6]' : 'border-white/70' }}">

                            <div class="flex-1 p-6">
                                <div class="mx-auto flex h-16 w-16 items-center justify-center overflow-hidden rounded-full bg-[#eef8f1] shadow-sm">
                                    <img src="{{ $category['image_url'] }}" alt="{{ $category['name'] }}" class="h-full w-full object-cover">
                                </div>

                                <h3 class="mt-5 text-sm font-extrabold uppercase tracking-wide text-[#2f7d4f]">
                                    {{ $category['name'] }}
                                </h3>

                                <p class="mx-auto mt-2 max-w-[220px] text-xs font-medium leading-relaxed text-slate-500">
                                    {{ $category['description'] }}
                                </p>
                            </div>

                            <div class="mt-auto rounded-b-3xl bg-[#2f7d4f] px-4 py-3 text-center text-xs font-extrabold text-white">
                                {{ $category['price_label'] }}
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>

            <section class="mt-10">
                <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h2 class="text-lg font-extrabold uppercase tracking-wide text-[#000000]">
                            2. Select Package
                        </h2>
                        <p class="mt-1 text-sm font-medium text-slate-500">
                            Showing packages for {{ $categoryTitle }}.
                        </p>
                    </div>

                    <div class="rounded-2xl border border-[#c9ead6] bg-white/70 px-4 py-3 text-xs font-bold text-[#2f7d4f] shadow-sm">
                        All packages include guided activities and basic safety equipment.
                    </div>
                </div>

                <div class="grid gap-6 lg:grid-cols-3">
                    @forelse($packages as $package)
                        @php
                            $packageName = $package->package_name ?? $package->name ?? 'Package';
                            $duration = $package->duration ?? $package->package_duration ?? null;
                            $description = $package->subtitle ?? $package->description ?? 'EduForest package prepared for outdoor learning and adventure activities.';
                            $includes = $formatList($package->includes ?? $package->activities ?? $package->facilities ?? '');
                            $image = $getImage($package);
                            $price = $package->$priceColumn ?? 0;
                        @endphp

                        <article class="flex min-h-[620px] flex-col overflow-hidden rounded-3xl border border-white/70 bg-white/80 p-4 shadow-[0_18px_50px_rgba(62,111,82,0.12)] backdrop-blur-xl">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-base font-extrabold uppercase tracking-wide text-[#2f7d4f]">
                                    {{ $packageName }}
                                </h3>

                                @if($duration)
                                    <span class="rounded-full border border-[#c9ead6] bg-[#f2fbf5] px-3 py-1 text-[11px] font-extrabold uppercase text-[#2f7d4f]">
                                        {{ $duration }}
                                    </span>
                                @endif
                            </div>

                            <div class="mt-4 overflow-hidden rounded-2xl bg-[#d8f3dc]">
                                <img src="{{ $image }}" alt="{{ $packageName }}" class="h-36 w-full object-cover">
                            </div>

                            <p class="mt-4 rounded-xl bg-[#eef8f1] px-4 py-3 text-xs font-semibold leading-relaxed text-slate-600">
                                {{ $description }}
                            </p>

                            @if(count($includes))
                                <div class="mt-4">
                                    <h4 class="text-xs font-extrabold uppercase tracking-wide text-slate-800">
                                        Includes
                                    </h4>

                                    <div class="mt-3 space-y-2">
                                        @foreach($includes as $item)
                                            <div class="flex items-center gap-2 text-xs font-semibold text-slate-600">
                                                <span class="flex h-4 w-4 items-center justify-center rounded-full bg-[#2f7d4f] text-[10px] text-white">
                                                    &#10003;
                                                </span>
                                                <span>{{ $item }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="mt-auto flex items-end justify-between border-t border-[#c9ead6]/70 pt-4">
                                <span class="text-xs font-bold uppercase tracking-wide text-slate-500">
                                    Price
                                </span>

                                <div class="text-right">
                                    <div class="text-3xl font-extrabold text-[#2f7d4f]">
                                        <span class="text-sm">{{ $currency }}</span> {{ number_format($price, 0) }}
                                    </div>
                                    <div class="text-xs font-bold text-slate-500">
                                        / person
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-3xl border border-white/70 bg-white/80 p-10 text-center shadow-sm">
                            <p class="text-sm font-semibold text-slate-400">No packages found.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </main>
    </div>
</body>
</html>