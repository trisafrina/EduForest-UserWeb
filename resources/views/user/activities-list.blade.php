@php
    $activityItems = $activities->map(function ($activity) {
        $rawImages = $activity->image_urls ?? '';
        $decodedImages = json_decode($rawImages, true);

        if (is_array($decodedImages)) {
            $images = $decodedImages;
        } else {
            $images = array_map('trim', explode(',', $rawImages));
        }

        $image = collect($images)->filter()->first()
            ?? 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png';

        $rawFacilities = $activity->facilities ?? '';
        $decodedFacilities = json_decode($rawFacilities, true);

        if (is_array($decodedFacilities)) {
            $facilities = $decodedFacilities;
        } else {
            $facilities = collect(explode(',', $rawFacilities))
                ->map(fn ($item) => trim($item))
                ->filter()
                ->values()
                ->all();
        }

        $activityName = strtolower($activity->name ?? '');

        $duration = match (true) {
            str_contains($activityName, 'hiking') => '3 - 4 Hours',
            str_contains($activityName, 'jungle') => '4 - 5 Hours',
            str_contains($activityName, 'orienteering') => '2 - 3 Hours',
            str_contains($activityName, 'river') => '2 - 3 Hours',
            str_contains($activityName, 'shelter') => '2 - 3 Hours',
            default => '2 - 3 Hours',
        };

        return [
            'id' => $activity->id,
            'name' => $activity->name ?? 'EduForest Activity',
            'description' => $activity->description ?? '',
            'image' => $image,
            'images' => collect($images)->filter()->values()->all(),
            'rating' => $activity->rating ?? '4.9',
            'duration' => $duration,
            'pax' => '35',
            'facilities' => count($facilities) ? $facilities : ['Activity equipment provided'],
            'bring' => [
                'Extra clothes',
                'Water bottle',
                'Comfortable shoes',
                'Positive attitude',
            ],
        ];
    })->values();

    $firstActivity = $activityItems->first();
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForest - Activities</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-[#eef8f1] antialiased overflow-x-hidden">

    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,#d8f3dc_0,#eef8f1_34%,#f8fbf7_72%)]">
        @include('profile.partials.topbar')

        <main class="mx-auto max-w-7xl px-5 py-10 lg:px-8 lg:py-14">
            <div class="grid gap-8 lg:grid-cols-[430px_1fr]">

                <section>
                    <div class="mb-6">
                        <h1 class="text-lg font-extrabold uppercase tracking-wide text-[#000000]">
                            All Activities
                        </h1>
                        <p class="mt-2 text-sm font-medium text-slate-500">
                            Click on an activity to view more details.
                        </p>
                    </div>

                    <div class="space-y-4">
                        @forelse($activityItems as $index => $activity)
                            <button
                                type="button"
                                data-activity-index="{{ $index }}"
                                class="activity-card w-full rounded-2xl border bg-white/80 p-3 text-left shadow-[0_14px_40px_rgba(62,111,82,0.10)] backdrop-blur-xl transition hover:-translate-y-0.5 hover:border-[#6ba982] hover:shadow-[0_18px_50px_rgba(62,111,82,0.16)] {{ $index === 0 ? 'border-[#6ba982] ring-2 ring-[#c9ead6]' : 'border-white/70' }}"
                            >
                                <div class="grid grid-cols-[120px_1fr] gap-4">
                                    <div class="h-24 overflow-hidden rounded-xl bg-[#d8f3dc]">
                                        <img
                                            src="{{ $activity['image'] }}"
                                            alt="{{ $activity['name'] }}"
                                            class="h-full w-full object-cover"
                                        >
                                    </div>

                                    <div class="min-w-0">
                                        <h2 class="truncate text-sm font-extrabold uppercase tracking-tight text-slate-900">
                                            {{ $activity['name'] }}
                                        </h2>

                                        <p class="mt-1 line-clamp-2 text-xs font-medium leading-relaxed text-slate-500">
                                            {{ $activity['description'] }}
                                        </p>

                                        <div class="mt-3 flex flex-wrap items-center gap-4 text-[11px] font-bold text-[#4d7f63]">
                                            <span class="inline-flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.75a6 6 0 0 0-12 0M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                                {{ $activity['pax'] }} Pax
                                            </span>

                                            <span class="inline-flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                                {{ $activity['duration'] }}
                                            </span>

                                            <span class="inline-flex items-center gap-1 text-amber-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                                                    <path d="M11.48 3.5a.6.6 0 0 1 1.04 0l2.1 4.25 4.7.68a.6.6 0 0 1 .33 1.02l-3.4 3.32.8 4.68a.6.6 0 0 1-.87.63L12 15.88l-4.2 2.2a.6.6 0 0 1-.86-.63l.8-4.68-3.4-3.32a.6.6 0 0 1 .33-1.02l4.7-.68 2.11-4.25Z" />
                                                </svg>
                                                {{ $activity['rating'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </button>
                        @empty
                            <div class="rounded-3xl border border-white/70 bg-white/80 p-10 text-center shadow-sm">
                                <p class="text-sm font-semibold text-slate-400">No activities found.</p>
                            </div>
                        @endforelse
                    </div>
                </section>

                <section class="rounded-[28px] border border-white/70 bg-white/80 p-6 shadow-[0_24px_70px_rgba(62,111,82,0.14)] backdrop-blur-xl lg:p-8">
                    @if($firstActivity)
                        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                            <div>
                                <h2 id="detailName" class="text-2xl font-extrabold uppercase tracking-tight text-slate-950">
                                    {{ $firstActivity['name'] }}
                                </h2>
                                <div class="mt-3 h-1.5 w-12 rounded-full bg-[#2f7d4f]"></div>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <span id="detailPax" class="rounded-xl border border-[#c9ead6] bg-[#f2fbf5] px-4 py-2 text-xs font-bold text-[#2f7d4f]">
                                    {{ $firstActivity['pax'] }} Pax Per Session
                                </span>

                                <span id="detailDuration" class="rounded-xl border border-[#c9ead6] bg-[#f2fbf5] px-4 py-2 text-xs font-bold text-[#2f7d4f]">
                                    {{ $firstActivity['duration'] }}
                                </span>
                            </div>
                        </div>

                        

                        <div class="relative mt-6 overflow-hidden rounded-3xl bg-[#d8f3dc] shadow-sm">
    <img
        id="detailImage"
        src="{{ $firstActivity['image'] }}"
        alt="{{ $firstActivity['name'] }}"
        class="h-[360px] w-full object-cover transition duration-500"
    >

    <button
        type="button"
        onclick="previousDetailImage()"
        class="absolute left-4 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-slate-800 shadow-md backdrop-blur transition hover:bg-white"
    >
        ‹
    </button>

    <button
        type="button"
        onclick="nextDetailImage()"
        class="absolute right-4 top-1/2 flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full bg-white/80 text-slate-800 shadow-md backdrop-blur transition hover:bg-white"
    >
        ›
    </button>

    <div id="detailImageDots" class="absolute bottom-4 left-1/2 flex -translate-x-1/2 gap-2"></div>
</div>

                        <div class="mt-7 grid gap-6 lg:grid-cols-[1fr_260px]">
                            <div>
                                <h3 class="text-sm font-extrabold uppercase tracking-wide text-[#2f7d4f]">
                                    Facilities Included
                                </h3>

                                <div id="detailFacilities" class="mt-4 grid gap-3 sm:grid-cols-2">
                                    @foreach($firstActivity['facilities'] as $facility)
                                        <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                                            <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2f7d4f] text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                                                    <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.25 7.25a1 1 0 0 1-1.4 0L3.3 9.2a1 1 0 1 1 1.4-1.4l4.05 4.04L15.3 5.3a1 1 0 0 1 1.4 0Z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                            {{ $facility }}
                                        </div>
                                    @endforeach
                                </div>

                                <h3 class="mt-7 text-sm font-extrabold uppercase tracking-wide text-[#2f7d4f]">
                                    Description
                                </h3>

                                <p id="detailLongDescription" class="mt-3 text-sm font-medium leading-relaxed text-slate-600">
                                    {{ $firstActivity['description'] }}
                                </p>
                            </div>

                            <div class="rounded-3xl bg-[#eef8f1] p-5">
                                <h3 class="text-sm font-extrabold uppercase tracking-wide text-[#2f7d4f]">
                                    What To Bring
                                </h3>

                                <ul id="detailBring" class="mt-4 space-y-2 text-sm font-medium text-slate-600">
                                    @foreach($firstActivity['bring'] as $item)
                                        <li class="flex gap-2">
                                            <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#2f7d4f]"></span>
                                            <span>{{ $item }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @else
                        <div class="py-20 text-center">
                            <p class="text-sm font-semibold text-slate-400">No activity selected.</p>
                        </div>
                    @endif
                </section>

            </div>
        </main>
    </div>

    <script>
    const activities = @json($activityItems);
    const cards = document.querySelectorAll('.activity-card');

    let currentImages = activities[0]?.images?.length ? activities[0].images : [activities[0]?.image];
    let currentImageIndex = 0;
    let carouselTimer = null;

    function renderDetailImage() {
        const image = document.getElementById('detailImage');
        const dots = document.getElementById('detailImageDots');

        if (!image || !dots || !currentImages.length) {
            return;
        }

        image.src = currentImages[currentImageIndex];

        dots.innerHTML = currentImages.map((_, index) => `
            <button
                type="button"
                onclick="goToDetailImage(${index})"
                class="h-2.5 rounded-full transition ${index === currentImageIndex ? 'w-7 bg-white' : 'w-2.5 bg-white/50'}"
                aria-label="Image ${index + 1}"
            ></button>
        `).join('');
    }

    function startCarousel() {
        clearInterval(carouselTimer);

        if (currentImages.length <= 1) {
            return;
        }

        carouselTimer = setInterval(() => {
            nextDetailImage();
        }, 3500);
    }

    function nextDetailImage() {
        if (!currentImages.length) {
            return;
        }

        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        renderDetailImage();
    }

    function previousDetailImage() {
        if (!currentImages.length) {
            return;
        }

        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        renderDetailImage();
    }

    function goToDetailImage(index) {
        currentImageIndex = index;
        renderDetailImage();
        startCarousel();
    }

    function listItems(items) {
        return (items || []).map(item => `
            <div class="flex items-center gap-2 text-sm font-semibold text-slate-600">
                <span class="flex h-5 w-5 items-center justify-center rounded-full bg-[#2f7d4f] text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-3.5 w-3.5">
                        <path fill-rule="evenodd" d="M16.7 5.3a1 1 0 0 1 0 1.4l-7.25 7.25a1 1 0 0 1-1.4 0L3.3 9.2a1 1 0 1 1 1.4-1.4l4.05 4.04L15.3 5.3a1 1 0 0 1 1.4 0Z" clip-rule="evenodd" />
                    </svg>
                </span>
                ${item}
            </div>
        `).join('');
    }

    function bringItems(items) {
        return (items || []).map(item => `
            <li class="flex gap-2">
                <span class="mt-2 h-1.5 w-1.5 rounded-full bg-[#2f7d4f]"></span>
                <span>${item}</span>
            </li>
        `).join('');
    }

    cards.forEach(card => {
        card.addEventListener('click', () => {
            const activity = activities[card.dataset.activityIndex];

            if (!activity) {
                return;
            }

            cards.forEach(item => {
                item.classList.remove('border-[#6ba982]', 'ring-2', 'ring-[#c9ead6]');
                item.classList.add('border-white/70');
            });

            card.classList.add('border-[#6ba982]', 'ring-2', 'ring-[#c9ead6]');
            card.classList.remove('border-white/70');

            document.getElementById('detailName').textContent = activity.name;
            document.getElementById('detailLongDescription').textContent = activity.description;
            document.getElementById('detailImage').alt = activity.name;
            document.getElementById('detailPax').textContent = `${activity.pax} Pax Per Session`;
            document.getElementById('detailDuration').textContent = activity.duration;
            document.getElementById('detailFacilities').innerHTML = listItems(activity.facilities);
            document.getElementById('detailBring').innerHTML = bringItems(activity.bring);

            currentImages = activity.images?.length ? activity.images : [activity.image];
            currentImageIndex = 0;

            renderDetailImage();
            startCarousel();
        });
    });

    renderDetailImage();
    startCarousel();
</script>

</body>
</html>