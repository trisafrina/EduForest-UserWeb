@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\DB;

    $userProfile = Auth::check()
        ? DB::table('profiles')->where('id', Auth::id())->first()
        : null;

    $userName = $userProfile->full_name ?? Auth::user()->name ?? '';
    $userPhone = $userProfile->phone_number ?? '';
    $userEmail = Auth::user()->email ?? '';

    $dateStatuses = collect($bookingDates ?? [])->mapWithKeys(function ($date) {
        return [
            \Carbon\Carbon::parse($date->booking_date)->format('Y-m-d') => strtolower($date->status),
        ];
    });

    $slotStatuses = collect($slots ?? [])->mapWithKeys(function ($slot) {
        $date = \Carbon\Carbon::parse($slot->event_date)->format('Y-m-d');
        $status = $slot->current_booked >= $slot->max_capacity ? 'fully_booked' : strtolower($slot->status);

        return [$date => $status];
    });

    $calendarStatuses = $dateStatuses->merge($slotStatuses);

    $packageData = collect($packages ?? [])->map(function ($package) {
    $name = strtoupper($package->name ?? $package->package_name ?? 'PACKAGE');

    $durationDays = match (true) {
        str_contains($name, 'PACKAGE A') || $name === 'A' => 1,
        str_contains($name, 'PACKAGE B') || $name === 'B' => 2,
        str_contains($name, 'PACKAGE C') || $name === 'C' => 3,
        default => 1,
    };

    $durationLabel = match ($durationDays) {
        1 => '1 Day',
        2 => '2 Days 1 Night',
        3 => '3 Days 2 Nights',
        default => '1 Day',
    };

    $activities = collect(explode(',', $package->activities ?? ''))
        ->map(fn ($item) => trim($item))
        ->filter()
        ->values();

    return [
        'id' => $package->id,
        'name' => $name,
        'subtitle' => $package->subtitle ?? $package->description ?? '',
        'activities' => $activities,
        'duration_days' => $durationDays,
        'duration_label' => $durationLabel,
        'price_upsi' => $package->price_upsi ?? 0,
        'price_gov' => $package->price_gov ?? 0,
        'price_public' => $package->price_public ?? 0,
        'price_international' => $package->price_international ?? 0,
    ];
})->values();

    $categories = [
        'upsi' => [
            'title' => 'UPSI Community',
            'desc' => 'Special package for Universiti Pendidikan Sultan Idris members',
            'price' => 'From RM 40 / person',
            'logo' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/UPSI%20COMMUNITY/upsi%20community.jpg',
        ],
        'gov' => [
            'title' => 'Government Agency',
            'desc' => 'Package for government agencies and statutory bodies',
            'price' => 'From RM 60 / person',
            'logo' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/GOVERNMENT%20AGENCIES/government.gif',
        ],
        'public' => [
            'title' => 'Public',
            'desc' => 'Package for public participants',
            'price' => 'From RM 80 / person',
            'logo' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/PUBLIC/public.webp',
        ],
        'international' => [
            'title' => 'International',
            'desc' => 'Package for international participants',
            'price' => 'From USD 36 / person',
            'logo' => 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/CATEGORIES/INTERNATIONAL/international.png',
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduForest - Booking</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');
        body { font-family: 'Montserrat', sans-serif; }
    </style>
</head>

<body class="min-h-screen bg-[#eef8f1] antialiased overflow-x-hidden">
    <div class="min-h-screen bg-[radial-gradient(circle_at_top_left,#d8f3dc_0,#eef8f1_34%,#f8fbf7_72%)]">
        @include('profile.partials.topbar')

        <main class="mx-auto max-w-7xl px-5 py-8 lg:px-8">

            <div class="mb-8 flex items-center justify-between gap-3 overflow-x-auto rounded-3xl bg-white/60 px-5 py-4 shadow-sm backdrop-blur-xl">
                @foreach([
                    1 => 'Choose Date',
                    2 => 'Choose Category',
                    3 => 'Choose Package',
                    4 => 'Booking Details',
                    5 => 'Review & Confirm',
                ] as $step => $label)
                    <div class="flex shrink-0 items-center gap-3">
                        <span data-step="{{ $step }}" class="flex h-8 w-8 items-center justify-center rounded-full text-xs font-extrabold {{ $step === 1 ? 'bg-[#2f7d4f] text-white' : 'bg-slate-200 text-slate-500' }}">
                            {{ $step }}
                        </span>
                        <span class="text-xs font-extrabold text-slate-600">{{ $label }}</span>
                    </div>

                    @if($step < 5)
                        <div class="h-px w-16 shrink-0 bg-slate-300"></div>
                    @endif
                @endforeach
            </div>

            <form action="{{ route('booking.confirmation') }}" method="POST" class="grid gap-6 lg:grid-cols-[1fr_360px]">
                @csrf

                <input type="hidden" id="booking_date" name="booking_date">
                <input type="hidden" id="checkout_date" name="checkout_date">
                <input type="hidden" id="category" name="category">
                <input type="hidden" id="package_id" name="package_id">
                <input type="hidden" id="package_name" name="package_name">
                <input type="hidden" id="package_days" name="package_days">
                <input type="hidden" id="package_label" name="package_label">

                <div class="space-y-6 rounded-[28px] border border-white/70 bg-white/80 p-6 shadow-[0_24px_70px_rgba(62,111,82,0.12)] backdrop-blur-xl">

                    <section>
                        <h2 class="text-lg font-extrabold text-slate-950">1. CHOOSE DATE</h2>

                        <div class="mt-4 rounded-3xl border border-[#d7eadf] bg-white/80 p-5">
                            <div class="mb-5 flex items-center justify-between">
                                <button type="button" onclick="changeMonth(-1)" class="rounded-full p-2 font-bold text-slate-700 hover:bg-[#eef8f1]">
                                    &lsaquo;
                                </button>

                                <h3 id="calendarTitle" class="text-base font-extrabold text-slate-950"></h3>

                                <button type="button" onclick="changeMonth(1)" class="rounded-full p-2 font-bold text-slate-700 hover:bg-[#eef8f1]">
                                    &rsaquo;
                                </button>
                            </div>

                            <div class="grid grid-cols-7 gap-2 text-center text-[11px] font-extrabold uppercase text-slate-400">
                                <div>Sun</div>
                                <div>Mon</div>
                                <div>Tue</div>
                                <div>Wed</div>
                                <div>Thu</div>
                                <div>Fri</div>
                                <div>Sat</div>
                            </div>

                            <div id="calendarDays" class="mt-3 grid grid-cols-7 gap-3 text-center"></div>

                            <div class="mt-5 flex items-center justify-center gap-6 text-xs font-semibold text-slate-500">
                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded bg-[#2f7d4f]"></span>
                                    Fully Booked
                                </div>

                                <div class="flex items-center gap-2">
                                    <span class="h-3 w-3 rounded bg-[#dc2626]"></span>
                                    Public Holiday
                                </div>
                            </div>
                        </div>
                    </section>

                    <section>
                        <h2 class="text-lg font-extrabold text-slate-950">2. CHOOSE CATEGORY</h2>
                        <p class="mt-1 text-sm font-medium text-slate-500">Select a category that best describes your group.</p>

                        <div class="mt-4 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                            @foreach($categories as $key => $category)
                                <button type="button" data-category-card="{{ $key }}" onclick="selectCategory('{{ $key }}')"
                                        class="flex min-h-[220px] flex-col overflow-hidden rounded-2xl border border-white/70 bg-white/80 text-center shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="flex-1 p-5">
                                        <div class="mx-auto flex h-14 w-14 items-center justify-center overflow-hidden rounded-full bg-[#eef8f1] shadow-sm">
                                            <img src="{{ $category['logo'] }}" alt="{{ $category['title'] }}" class="h-full w-full object-contain">
                                        </div>

                                        <h3 class="mt-4 text-xs font-extrabold uppercase text-[#2f7d4f]">{{ $category['title'] }}</h3>
                                        <p class="mt-2 text-[11px] font-medium leading-relaxed text-slate-500">{{ $category['desc'] }}</p>
                                    </div>

                                <div class="mt-auto bg-[#2f7d4f] px-3 py-2 text-[11px] font-extrabold text-white">
                                        {{ $category['price'] }}
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </section>

                    <section>
                        <h2 class="text-lg font-extrabold text-slate-950">3. CHOOSE PACKAGES</h2>
                        <p class="mt-1 text-sm font-medium text-slate-500">Select a package that suits your plan.</p>

                        <div class="mt-4 grid gap-4 xl:grid-cols-3">
                            @foreach($packageData as $index => $package)
                                <button type="button" data-package-card="{{ $index }}" onclick="selectPackage({{ $index }})"
    class="flex min-h-[260px] flex-col rounded-2xl border border-white/70 bg-white/80 p-4 text-left shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <h3 class="text-sm font-extrabold uppercase text-[#2f7d4f]">{{ $package['name'] }}</h3>

                                            <span class="mt-2 inline-flex rounded-full bg-[#eef8f1] px-3 py-1 text-[11px] font-bold text-[#2f7d4f]">
                                                {{ $package['duration_label'] }}
                                            </span>
                                        </div>
                                    </div>

                                    @if($package['activities']->count())
                                        <ul class="mt-4 space-y-1 text-xs font-semibold text-slate-600">
                                            @foreach($package['activities'] as $activity)
                                                <li class="flex gap-2">
                                                    <span class="text-[#2f7d4f]">•</span>
                                                    <span>{{ $activity }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif

                                   <div class="mt-auto flex items-end justify-between pt-4">
                                        <div>
                                            <span class="text-xs font-bold text-[#2f7d4f]" data-package-price="{{ $index }}">Select category</span>
                                            <span class="text-xs text-slate-500"> / person</span>
                                        </div>

                                        <span class="rounded-xl border border-[#2f7d4f] px-4 py-2 text-xs font-extrabold text-[#2f7d4f]">
                                            Select Package
                                        </span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </section>

                    <section>
                        <h2 class="text-lg font-extrabold text-slate-950">4. BOOKING DETAILS</h2>

                        <div class="mt-4 grid gap-4 md:grid-cols-2">
                            <div>
                                <label class="text-xs font-extrabold uppercase text-slate-500">Check-in</label>
                                <input type="date" id="checkInPicker" class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-white px-4 py-3 text-sm font-bold text-slate-700">
                            </div>

                            <div>
                                <label class="text-xs font-extrabold uppercase text-slate-500">Check-out</label>
                                <input type="date" id="checkOutPicker" readonly class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-slate-50 px-4 py-3 text-sm font-bold text-slate-500">
                            </div>

                            <div>
                                <label class="text-xs font-extrabold uppercase text-slate-500">Participants</label>
                                <input type="number" id="total_pax" name="total_pax" min="1" value="1" oninput="setPax(this.value)" class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-white px-4 py-3 text-sm font-bold text-slate-700">
                            </div>

                            <div>
                                <label class="text-xs font-extrabold uppercase text-slate-500">Organization / Group</label>
                                <input type="text" name="organization_name" class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-white px-4 py-3 text-sm font-medium text-slate-700">
                            </div>

                            <div>
                                <label class="text-xs font-extrabold uppercase text-slate-500">Contact Person</label>
                                <input type="text" name="client_name" value="{{ $userName }}" required class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-white px-4 py-3 text-sm font-medium text-slate-700">
                            </div>

                            <div>
                                <label class="text-xs font-extrabold uppercase text-slate-500">Phone Number</label>
                                <input type="tel" name="client_number" value="{{ $userPhone }}" required class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-white px-4 py-3 text-sm font-medium text-slate-700">
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-xs font-extrabold uppercase text-slate-500">Email</label>
                                <input type="email" name="client_email" value="{{ $userEmail }}" readonly class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-slate-50 px-4 py-3 text-sm font-medium text-slate-500">
                            </div>

                            <div class="md:col-span-2">
                                <label class="text-xs font-extrabold uppercase text-slate-500">Special Request</label>
                                <textarea name="special_requests" rows="3" class="mt-2 w-full rounded-xl border border-[#d7eadf] bg-white px-4 py-3 text-sm font-medium text-slate-700"></textarea>
                            </div>
                        </div>
                    </section>
                </div>

                <aside class="self-start rounded-[28px] border border-white/70 bg-white/80 p-6 shadow-[0_24px_70px_rgba(62,111,82,0.12)] backdrop-blur-xl">
                    <h2 class="text-lg font-extrabold text-slate-950">Booking Summary</h2>

                    <div class="mt-6 space-y-5 text-sm">
                        <div>
                            <h3 class="text-xs font-extrabold uppercase text-slate-900">Date & Duration</h3>
                            <div class="mt-3 space-y-2 text-slate-600">
                                <p class="flex justify-between"><span>Check-in</span><span id="summaryCheckIn">-</span></p>
                                <p class="flex justify-between"><span>Check-out</span><span id="summaryCheckOut">-</span></p>
                                <p class="flex justify-between"><span>Duration</span><span id="summaryDuration">-</span></p>
                            </div>
                        </div>

                        <div class="border-t border-[#d7eadf] pt-4">
                            <h3 class="text-xs font-extrabold uppercase text-slate-900">Category</h3>
                            <div class="mt-3 space-y-2 text-slate-600">
                                <p class="flex justify-between"><span>Category</span><span id="summaryCategory">-</span></p>
                                <p class="flex justify-between"><span>Rate</span><span id="summaryRate">-</span></p>
                            </div>
                        </div>

                        <div class="border-t border-[#d7eadf] pt-4">
                            <h3 class="text-xs font-extrabold uppercase text-slate-900">Package</h3>
                            <div class="mt-3 space-y-2 text-slate-600">
                                <p class="flex justify-between"><span>Package</span><span id="summaryPackage">-</span></p>
                                <p><span class="block font-medium">Activities</span><span id="summaryActivities" class="mt-1 block text-xs leading-relaxed">-</span></p>
                            </div>
                        </div>

                        <div class="border-t border-[#d7eadf] pt-4">
                            <h3 class="text-xs font-extrabold uppercase text-slate-900">Participants</h3>
                            <div class="mt-3 space-y-2 text-slate-600">
                                <p class="flex justify-between"><span>Participants</span><span id="summaryPax">1 Pax</span></p>
                                <p class="flex justify-between"><span>Price / person</span><span id="summaryPricePerPerson">-</span></p>
                            </div>
                        </div>

                        <div class="border-t border-[#d7eadf] pt-5">
                            <p class="flex items-center justify-between text-base font-extrabold text-slate-950">
                                <span>Total Price</span>
                                <span id="summaryTotal" class="text-[#2f7d4f]">RM 0.00</span>
                            </p>
                        </div>

                        <div class="rounded-2xl border border-[#d7eadf] bg-[#eef8f1] p-4">
                            <p class="text-xs font-extrabold text-[#2f7d4f]">Ready to continue?</p>
                            <p class="mt-1 text-xs font-medium leading-relaxed text-slate-500">Submit payment after confirming your booking detail.</p>
                            <button type="submit" class="mt-4 w-full rounded-xl bg-[#2f7d4f] px-4 py-3 text-sm font-extrabold text-white transition hover:bg-[#256f43]">
                                Submit Payment
                            </button>
                        </div>
                    </div>
                </aside>
            </form>
        </main>
    </div>

    <script>
        const dateStatuses = @json($calendarStatuses);
        const packages = @json($packageData);

        let selectedDate = null;
        let selectedCategory = null;
        let selectedPackage = null;
        let selectedPax = 1;
        let currentDate = new Date();

        function setStep(step) {
            document.querySelectorAll('[data-step]').forEach(el => {
                const active = Number(el.dataset.step) <= step;
                el.classList.toggle('bg-[#2f7d4f]', active);
                el.classList.toggle('text-white', active);
                el.classList.toggle('bg-slate-200', !active);
                el.classList.toggle('text-slate-500', !active);
            });
        }

        function renderCalendar() {
            const title = document.getElementById('calendarTitle');
            const grid = document.getElementById('calendarDays');

            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            title.textContent = `${monthNames[month]} ${year}`;
            grid.innerHTML = '';

            const firstDay = new Date(year, month, 1).getDay();
            const lastDay = new Date(year, month + 1, 0).getDate();

            for (let i = 0; i < firstDay; i++) {
                grid.appendChild(document.createElement('div'));
            }

            for (let day = 1; day <= lastDay; day++) {
                const button = document.createElement('button');
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const status = dateStatuses[dateString] || 'normal';

                button.type = 'button';
                button.textContent = day;
                button.className = 'rounded-lg px-2 py-2 text-sm font-extrabold transition';

                const blocked = ['fully_booked', 'public_holiday', 'blocked', 'unavailable', 'closed'].includes(status);

                if (status === 'fully_booked') {
                    button.className += ' bg-[#18b985] text-white cursor-not-allowed shadow-sm';
                    button.disabled = true;
                } else if (['public_holiday', 'blocked', 'unavailable', 'closed', 'holiday'].includes(status)) {
                    button.className += ' bg-red-600 text-white cursor-not-allowed shadow-sm';
                    button.disabled = true;
                } else if (selectedDate === dateString) {
                    button.className += ' bg-[#2f7d4f] text-white ring-2 ring-[#c9ead6] shadow-sm';
                    button.onclick = () => selectDate(dateString);
                } else {
                    button.className += ' bg-slate-50 text-slate-800 hover:bg-[#eef8f1]';
                    button.onclick = () => selectDate(dateString);
                }

                grid.appendChild(button);
            }
        }

        function changeMonth(direction) {
            currentDate.setMonth(currentDate.getMonth() + direction);
            renderCalendar();
        }

        function selectDate(date) {
            selectedDate = date;
            document.getElementById('summaryCheckIn').textContent = date;
            document.getElementById('booking_date').value = date;
            document.getElementById('checkInPicker').value = date;

            updateCheckout();
            setStep(2);
            renderCalendar();
        }

        function selectCategory(category) {
            selectedCategory = category;
            document.getElementById('category').value = category;
            document.getElementById('summaryCategory').textContent = category.toUpperCase();

            document.querySelectorAll('[data-category-card]').forEach(card => {
                const active = card.dataset.categoryCard === category;
                card.classList.toggle('ring-2', active);
                card.classList.toggle('ring-[#2f7d4f]', active);
                card.classList.toggle('border-[#2f7d4f]', active);
            });

            updatePackagePrices();
            updatePrice();
            setStep(3);
        }

        function selectPackage(index) {
            selectedPackage = packages[index];

            document.getElementById('package_id').value = selectedPackage.id;
            document.getElementById('package_name').value = selectedPackage.name;
            document.getElementById('package_days').value = selectedPackage.duration_days;
            document.getElementById('package_label').value = selectedPackage.duration_label;

            document.getElementById('summaryPackage').textContent = selectedPackage.name;
            document.getElementById('summaryActivities').textContent = selectedPackage.activities.join(', ') || '-';
            document.getElementById('summaryDuration').textContent = selectedPackage.duration_label;

            document.querySelectorAll('[data-package-card]').forEach(card => {
                const active = Number(card.dataset.packageCard) === index;
                card.classList.toggle('ring-2', active);
                card.classList.toggle('ring-[#2f7d4f]', active);
                card.classList.toggle('border-[#2f7d4f]', active);
            });

            updateCheckout();
            updatePrice();
            setStep(4);
        }

        function getPriceColumn() {
            if (selectedCategory === 'gov') return 'price_gov';
            if (selectedCategory === 'public') return 'price_public';
            if (selectedCategory === 'international') return 'price_international';
            return 'price_upsi';
        }

        function getCurrency() {
            return selectedCategory === 'international' ? 'USD' : 'RM';
        }

        function updateCheckout() {
            if (!selectedDate || !selectedPackage) return;

            const date = new Date(selectedDate);
            date.setDate(date.getDate() + (Number(selectedPackage.duration_days) - 1));

            const checkout = date.toISOString().split('T')[0];

            document.getElementById('checkout_date').value = checkout;
            document.getElementById('checkOutPicker').value = checkout;
            document.getElementById('summaryCheckOut').textContent = checkout;
        }

        function updatePrice() {
            if (!selectedPackage || !selectedCategory) return;

            const price = Number(selectedPackage[getPriceColumn()] || 0);
            const total = price * selectedPax;
            const currency = getCurrency();

            document.getElementById('summaryRate').textContent = `${currency} ${price.toFixed(2)}`;
            document.getElementById('summaryPricePerPerson').textContent = `${currency} ${price.toFixed(2)}`;
            document.getElementById('summaryTotal').textContent = `${currency} ${total.toFixed(2)}`;
        }

        function updatePackagePrices() {
            document.querySelectorAll('[data-package-price]').forEach(el => {
                const pkg = packages[Number(el.dataset.packagePrice)];
                const currency = getCurrency();
                const price = selectedCategory ? Number(pkg[getPriceColumn()] || 0) : 0;
                el.textContent = selectedCategory ? `${currency} ${price}` : 'Select category';
            });
        }

        function setPax(value) {
            selectedPax = Math.max(1, Number(value || 1));
            document.getElementById('total_pax').value = selectedPax;
            document.getElementById('summaryPax').textContent = `${selectedPax} Pax`;
            updatePrice();
            setStep(5);
        }

        document.getElementById('checkInPicker').addEventListener('change', function () {
            if (!this.value) return;
            selectDate(this.value);
        });

        renderCalendar();
        updatePackagePrices();
    </script>
</body>
</html>