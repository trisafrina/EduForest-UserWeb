@php
    use Illuminate\Support\Facades\DB;

    $defaultImage = 'https://acufjzcdzmpwgyzwzgek.supabase.co/storage/v1/object/public/images/EDUFOREST%20LOGO/eduforest_logo-removebg-preview.png';
@endphp

<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
            background: #f7f7f7;
        }

        .tab-active {
            background: white;
            color: #2d6a4f;
            box-shadow: 0 2px 8px rgba(0,0,0,.08);
        }
    </style>
</head>

<body class="min-h-screen">

@include('profile.partials.topbar')

<main class="max-w-5xl mx-auto px-5 py-10">

    <div class="mb-8">
        <h1 class="text-4xl font-black text-black">My Bookings</h1>
        <p class="text-xl text-slate-500 font-medium mt-3">View and manage your booking history.</p>
    </div>

    <div class="bg-gray-200 rounded-full p-1 flex mb-10">
        <button id="upcomingBtn" class="tab-active w-1/2 rounded-full py-4 font-extrabold transition">
            Upcoming
        </button>

        <button id="historyBtn" class="w-1/2 rounded-full py-4 text-gray-400 font-extrabold transition">
            History
        </button>
    </div>

    <div id="upcomingSection" class="space-y-6">
        @forelse($bookings as $booking)
            @php
                $package = DB::table('packages')->where('id', $booking->package_id)->first();

                $packageName = $package->package_name ?? $package->name ?? 'Package';
                $packageImage = $package->image_url ?? $defaultImage;

                $checkIn = $booking->check_in_date ?? null;
                $checkOut = $booking->check_out_date ?? null;

                if ($checkIn && $checkOut) {
                    $dateText = \Carbon\Carbon::parse($checkIn)->format('d') . ' - ' . \Carbon\Carbon::parse($checkOut)->format('d F Y');
                } else {
                    $dateText = '-';
                }

                $guest = $booking->total_pax ?? 1;
                $total = $booking->total_amount ?? 0;
                $currency = strtolower($booking->selected_category ?? '') === 'international' ? 'USD' : 'RM';

                $paymentStatus = strtolower($booking->payment_status ?? 'pending');

                if ($paymentStatus === 'approved') {
                    $statusLabel = 'Payment Verified';
                    $statusClass = 'bg-[#ecfdf5] text-[#047857]';
                } elseif ($paymentStatus === 'verified') {
                    $statusLabel = 'Payment Verified';
                    $statusClass = 'bg-[#ecfdf5] text-[#047857]';
                } elseif ($paymentStatus === 'rejected') {
                    $statusLabel = 'Rejected';
                    $statusClass = 'bg-[#fef2f2] text-[#b91c1c]';
                } else {
                    $statusLabel = 'Pending Payment';
                    $statusClass = 'bg-white text-[#2d6a4f]';
                }
            @endphp

            <div onclick="document.getElementById('bookingModal{{ $booking->id }}').classList.remove('hidden')"
                class="bg-[#edf4f1] rounded-[28px] shadow-sm p-4 flex gap-4 border border-[#e2ece9] cursor-pointer hover:-translate-y-1 hover:shadow-lg transition">
                <div class="w-40 h-40 rounded-2xl overflow-hidden bg-white flex-shrink-0 shadow-sm">
                    <img src="{{ $packageImage }}" class="w-full h-full object-cover" alt="{{ $packageName }}">
                </div>

                <div class="flex-1">
                    <div class="flex items-start justify-between gap-3 mb-5">
                        <h2 class="font-black text-2xl uppercase text-[#1e4634] tracking-tight">
                            {{ $packageName }}
                        </h2>

                        <span class="shrink-0 rounded-full border px-5 py-2 text-sm font-black uppercase tracking-wide {{ $statusClass }}">
                            {{ $statusLabel }}
                        </span>
                    </div>

                    <div class="border-t border-[#d7e5df] pt-5 space-y-4">
                        <div class="flex justify-between gap-4">
                            <span class="text-slate-500 font-medium">Dates</span>
                            <span class="font-bold text-[#1e4634] text-right">{{ $dateText }}</span>
                        </div>

                        <div class="flex justify-between gap-4">
                            <span class="text-slate-500 font-medium">Guest</span>
                            <span class="font-bold text-[#1e4634]">{{ $guest }} pax</span>
                        </div>

                        <div class="flex justify-between items-end gap-4">
                            <span class="text-slate-600 font-bold">Total Price</span>
                            <span class="font-black text-3xl text-[#2d6a4f]">
                                {{ $currency }} {{ number_format($total, 0) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="bookingModal{{ $booking->id }}"
     class="hidden fixed inset-0 z-[999] bg-black/40 backdrop-blur-sm flex items-center justify-center px-4">

    <div class="w-full max-w-md rounded-[32px] bg-white shadow-2xl border border-[#dcebe4] p-7 relative">

        <button onclick="document.getElementById('bookingModal{{ $booking->id }}').classList.add('hidden')"
                class="absolute top-5 right-5 w-10 h-10 rounded-full bg-[#edf4f1] text-[#2d6a4f] font-black hover:bg-[#dcebe4] transition">
            ×
        </button>

        <h2 class="text-2xl font-black text-[#0f172a] mb-8">Booking Summary</h2>

        @php
            $category = strtoupper($booking->selected_category ?? '-');
            $currency = strtolower($booking->selected_category ?? '') === 'international' ? 'USD' : 'RM';
            $pricePerPerson = ($guest ?? 1) > 0 ? ($total / $guest) : $total;

            $durationText = '-';
            if ($checkIn && $checkOut) {
                $days = \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)) + 1;
                $nights = max($days - 1, 0);
                $durationText = $days . ' Day' . ($days > 1 ? 's' : '');
                if ($nights > 0) {
                    $durationText .= ' ' . $nights . ' Night' . ($nights > 1 ? 's' : '');
                }
            }

            $activitiesText = $package->activities ?? '-';
        @endphp

        <div class="space-y-6 text-[#52627a]">

            <div>
                <h3 class="text-sm font-black text-[#0f172a] uppercase mb-3">Date & Duration</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <span>Check-in</span>
                        <span class="font-semibold text-[#344256]">{{ $checkIn ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span>Check-out</span>
                        <span class="font-semibold text-[#344256]">{{ $checkOut ?? '-' }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span>Duration</span>
                        <span class="font-semibold text-[#344256]">{{ $durationText }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#d7e5df] pt-5">
                <h3 class="text-sm font-black text-[#0f172a] uppercase mb-3">Category</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <span>Category</span>
                        <span class="font-semibold text-[#344256]">{{ $category }}</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span>Rate</span>
                        <span class="font-semibold text-[#344256]">
                            {{ $currency }} {{ number_format($pricePerPerson, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#d7e5df] pt-5">
                <h3 class="text-sm font-black text-[#0f172a] uppercase mb-3">Package</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <span>Package</span>
                        <span class="font-semibold text-[#344256]">{{ strtoupper($packageName) }}</span>
                    </div>

                    <div>
                        <span>Activities</span>
                        <p class="mt-2 leading-relaxed text-[#52627a]">{{ $activitiesText }}</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#d7e5df] pt-5">
                <h3 class="text-sm font-black text-[#0f172a] uppercase mb-3">Participants</h3>

                <div class="space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <span>Participants</span>
                        <span class="font-semibold text-[#344256]">{{ $guest }} Pax</span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span>Price / person</span>
                        <span class="font-semibold text-[#344256]">
                            {{ $currency }} {{ number_format($pricePerPerson, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="border-t border-[#d7e5df] pt-5 flex justify-between items-center">
                <span class="text-lg font-black text-[#0f172a]">Total Price</span>
                <span class="text-2xl font-black text-[#2d6a4f]">
                    {{ $currency }} {{ number_format($total, 2) }}
                </span>
            </div>

            @if(!empty($booking->invoice_url))
                <a href="{{ $booking->invoice_url }}" target="_blank"
                class="block w-full text-center rounded-2xl bg-[#2d6a4f] py-4 font-black text-white shadow-md hover:bg-[#1e4634] transition">
                    Download Invoice
                </a>
            @else
                <div class="rounded-2xl bg-[#edf4f1] border border-[#d7e5df] p-4 text-sm text-[#52627a]">
                    <strong class="text-[#2d6a4f]">Invoice not available yet.</strong><br>
                    The invoice will appear here after admin uploads it.
                </div>
            @endif

        </div>
    </div>
</div>
        @empty
            <div class="bg-[#edf4f1] rounded-3xl p-12 text-center shadow-sm border border-[#e2ece9]">
                <h2 class="text-2xl font-bold text-[#2d6a4f]">No Booking Yet</h2>
                <p class="mt-3 text-gray-500">You haven't made any booking.</p>

                <a href="{{ route('booking.categories') }}"
                    class="inline-block mt-6 bg-[#2d6a4f] hover:bg-[#1e4634] transition text-white px-6 py-3 rounded-xl font-bold">
                    Book Now
                </a>
            </div>
        @endforelse
    </div>

    <div id="historySection" class="hidden">
        <div class="bg-[#edf4f1] rounded-[28px] shadow-sm p-14 border border-[#e2ece9] text-center">
            <h2 class="text-2xl font-extrabold text-[#2d6a4f]">No Booking History</h2>
            <p class="mt-3 text-gray-500 leading-relaxed">
                Your completed bookings will appear here after your activities have finished.
            </p>
        </div>
    </div>

</main>

<script>
    const upcomingBtn = document.getElementById('upcomingBtn');
    const historyBtn = document.getElementById('historyBtn');
    const upcoming = document.getElementById('upcomingSection');
    const history = document.getElementById('historySection');

    upcomingBtn.addEventListener('click', function () {
        upcoming.classList.remove('hidden');
        history.classList.add('hidden');

        upcomingBtn.classList.add('tab-active');
        historyBtn.classList.remove('tab-active');
        historyBtn.classList.add('text-gray-400');
    });

    historyBtn.addEventListener('click', function () {
        history.classList.remove('hidden');
        upcoming.classList.add('hidden');

        historyBtn.classList.add('tab-active');
        historyBtn.classList.remove('text-gray-400');

        upcomingBtn.classList.remove('tab-active');
    });
</script>

</body>
</html>