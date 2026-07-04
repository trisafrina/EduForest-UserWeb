@extends('layouts.admin-master')

@section('page-title', 'Welcome Back, Admin')

@section('content')
@php
    $month = (int) request('month', now()->month);
$year = (int) request('year', now()->year);

$currentMonthDate = \Carbon\Carbon::create($year, $month, 1);
$previousMonthDate = $currentMonthDate->copy()->subMonth();
$nextMonthDate = $currentMonthDate->copy()->addMonth();

    $firstDay = \Carbon\Carbon::create($year, $month, 1);
    $startCalendar = $firstDay->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
    $endCalendar = $firstDay->copy()->endOfMonth()->endOfWeek(\Carbon\Carbon::SATURDAY);

    $days = [];
    $cursor = $startCalendar->copy();

    while ($cursor <= $endCalendar) {
        $days[] = $cursor->copy();
        $cursor->addDay();
    }

    $bookingEvents = [];

    foreach (($calendarBookings ?? []) as $booking) {
        if (! empty($booking->check_in_date) && ! empty($booking->check_out_date)) {
            $start = \Carbon\Carbon::parse($booking->check_in_date);
            $end = \Carbon\Carbon::parse($booking->check_out_date);

            while ($start <= $end) {
                $dateKey = $start->format('Y-m-d');

                if (! isset($bookingEvents[$dateKey])) {
                    $bookingEvents[$dateKey] = [];
                }

                $bookingEvents[$dateKey][] = $booking;
                $start->addDay();
            }
        }
    }

    $holidayDates = collect($calendarRestrictions ?? [])->mapWithKeys(function ($item) {
        return [\Carbon\Carbon::parse($item->booking_date)->format('Y-m-d') => $item->status ?? 'holiday'];
    });

    $packageColor = function ($packageName) {
        $name = strtoupper($packageName ?? '');

        if (str_contains($name, 'A')) {
            return [
                'bg' => '#dcfce7',
                'border' => '#22c55e',
                'text' => '#166534',
            ];
        }

        if (str_contains($name, 'B')) {
            return [
                'bg' => '#fef3c7',
                'border' => '#f59e0b',
                'text' => '#92400e',
            ];
        }

        if (str_contains($name, 'C')) {
            return [
                'bg' => '#ede9fe',
                'border' => '#8b5cf6',
                'text' => '#5b21b6',
            ];
        }

        return [
            'bg' => '#dbeafe',
            'border' => '#3b82f6',
            'text' => '#1e40af',
        ];
    };

    $statusLabel = function ($paymentStatus) {
        $status = strtolower($paymentStatus ?? 'pending');

        if ($status === 'approved' || $status === 'verified') {
            return ['Upcoming', '#ecfdf5', '#047857', '#a7f3d0'];
        }

        if ($status === 'rejected') {
            return ['Rejected', '#fef2f2', '#b91c1c', '#fecaca'];
        }

        return ['Pending', '#fffbeb', '#b45309', '#fde68a'];
    };
@endphp

<style>
    .admin-dashboard-wrap {
        display: grid;
        gap: 1.5rem;
    }

    .dashboard-stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 1rem;
    }

    .dashboard-stat-card {
        background: rgba(255, 255, 255, 0.86);
        border: 1px solid #e6eee9;
        border-radius: 26px;
        padding: 1.5rem;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
    }

    .dashboard-stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 17px;
        display: grid;
        place-items: center;
        margin-bottom: 1.2rem;
        font-size: 1.2rem;
    }

    .dashboard-stat-value {
        font-size: 2rem;
        line-height: 1;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 0.5rem;
    }

    .dashboard-stat-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: #64748b;
    }

    .dashboard-main-grid {
        display: grid;
        grid-template-columns: minmax(0, 1.15fr) minmax(420px, 0.85fr);
        gap: 1.5rem;
        align-items: start;
    }

    .dashboard-panel {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #e6eee9;
        border-radius: 28px;
        padding: 1.5rem;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.06);
    }

    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.2rem;
    }

    .panel-title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 900;
        color: #0f172a;
    }

    .panel-subtitle {
        margin: 0.3rem 0 0;
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .view-all-link {
        display: inline-flex;
        align-items: center;
        gap: 0.45rem;
        color: #2f855a;
        font-weight: 800;
        font-size: 0.85rem;
        text-decoration: none;
    }

    .recent-table {
        width: 100%;
        border-collapse: collapse;
        overflow: hidden;
    }

    .recent-table th {
        text-align: left;
        color: #64748b;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        padding: 0.85rem 0.65rem;
        border-bottom: 1px solid #edf2f7;
    }

    .recent-table td {
        padding: 1rem 0.65rem;
        border-bottom: 1px solid #edf2f7;
        vertical-align: middle;
    }

    .client-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        background: #eef6f0;
        color: #2f855a;
        font-weight: 900;
        flex: 0 0 auto;
    }

    .client-cell {
        display: flex;
        gap: 0.75rem;
        align-items: center;
    }

    .client-name {
        font-weight: 900;
        color: #0f172a;
    }

    .client-id {
        color: #94a3b8;
        font-size: 0.72rem;
        margin-top: 0.12rem;
    }

    .pill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        padding: 0.35rem 0.7rem;
        font-size: 0.75rem;
        font-weight: 900;
        white-space: nowrap;
    }

    .calendar-card {
        min-height: 520px;
    }

    .calendar-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .calendar-month {
        font-weight: 900;
        color: #0f172a;
        font-size: 1.05rem;
    }

    .calendar-nav {
        display: inline-flex;
        gap: 0.45rem;
    }

    .calendar-nav a {
    border: 1px solid #e2e8f0;
    background: #ffffff;
    width: 32px;
    height: 32px;
    border-radius: 10px;
    color: #64748b;
    font-weight: 900;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
}

.calendar-nav a:hover {
    background: #f0fdf4;
    color: #2f855a;
    border-color: #bbf7d0;
}

    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, minmax(0, 1fr));
        border: 1px solid #edf2f7;
        border-radius: 18px;
        overflow: hidden;
    }

    .calendar-day-name {
        padding: 0.75rem 0.55rem;
        font-size: 0.72rem;
        font-weight: 900;
        color: #64748b;
        background: #f8fafc;
        text-align: center;
        border-bottom: 1px solid #edf2f7;
    }

    .calendar-cell {
        min-height: 88px;
        padding: 0.45rem;
        border-right: 1px solid #edf2f7;
        border-bottom: 1px solid #edf2f7;
        background: #ffffff;
    }

    .calendar-cell:nth-child(7n) {
        border-right: none;
    }

    .calendar-cell.muted {
        background: #fafafa;
        color: #cbd5e1;
    }

    .calendar-number {
        font-size: 0.78rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }

    .calendar-cell.muted .calendar-number {
        color: #cbd5e1;
    }

    .calendar-holiday {
        background: #fee2e2;
        border-left: 4px solid #dc2626;
        color: #991b1b;
        border-radius: 8px;
        padding: 0.25rem 0.35rem;
        font-size: 0.66rem;
        font-weight: 900;
        line-height: 1.15;
        margin-top: 0.25rem;
    }

    .calendar-event {
        border-left: 4px solid;
        border-radius: 8px;
        padding: 0.25rem 0.35rem;
        font-size: 0.66rem;
        font-weight: 900;
        line-height: 1.15;
        margin-top: 0.25rem;
        overflow: hidden;
    }

    .calendar-event span {
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .calendar-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 0.8rem;
        margin-top: 1rem;
        color: #64748b;
        font-size: 0.78rem;
        font-weight: 800;
    }

    .legend-dot {
        width: 11px;
        height: 11px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 0.35rem;
    }

    @media (max-width: 1200px) {
        .dashboard-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-main-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="admin-dashboard-wrap">
    <div class="dashboard-stat-grid">
        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon" style="background:#ecfdf5; color:#047857;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="dashboard-stat-value">{{ $totalClients ?? 0 }}</div>
            <div class="dashboard-stat-label">Registered Clients</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon" style="background:#fffbeb; color:#b45309;">
                <i class="fa-solid fa-file-invoice"></i>
            </div>
            <div class="dashboard-stat-value">{{ $pendingBookings ?? 0 }}</div>
            <div class="dashboard-stat-label">Pending Booking Requests</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon" style="background:#eff6ff; color:#2563eb;">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <div class="dashboard-stat-value">{{ $pendingPayments ?? 0 }}</div>
            <div class="dashboard-stat-label">Payments Awaiting Verification</div>
        </div>

        <div class="dashboard-stat-card">
            <div class="dashboard-stat-icon" style="background:#fdf2f8; color:#db2777;">
                <i class="fa-solid fa-calendar-days"></i>
            </div>
            <div class="dashboard-stat-value">{{ $blockedDatesCount ?? 0 }}</div>
            <div class="dashboard-stat-label">Calendar Restrictions Active</div>
        </div>
    </div>

    <div class="dashboard-main-grid">
        <div class="dashboard-panel">
            <div class="panel-head">
                <div>
                    <h2 class="panel-title">Recent Booking Activity</h2>
                    <p class="panel-subtitle">Senarai permohonan tempahan terkini daripada pelanggan Edu-Forest.</p>
                </div>

                <a href="{{ route('admin.bookings.index') }}" class="view-all-link">
                    View all
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>

            <table class="recent-table">
                <thead>
                    <tr>
                        <th>Client Information</th>
                        <th>Package Details</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse(($recentBookings ?? []) as $booking)
                        @php
                            $initial = strtoupper(substr($booking->client_name ?? 'A', 0, 1));
                            $packageName = $booking->package_name ?? ('Package ' . ($booking->package_id ?? '-'));
                            $currency = strtolower($booking->selected_category ?? '') === 'international' ? 'USD' : 'RM';
                            [$label, $bg, $text, $border] = $statusLabel($booking->payment_status ?? null);
                        @endphp

                        <tr>
                            <td>
                                <div class="client-cell">
                                    <div class="client-avatar">{{ $initial }}</div>
                                    <div>
                                        <div class="client-name">{{ $booking->client_name ?? 'No Name' }}</div>
                                        <div class="client-id">ID: {{ $booking->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="pill" style="background:#ecfdf5; color:#047857; border:1px solid #a7f3d0;">
                                    {{ $booking->selected_category ?? 'PUBLIC' }}
                                </span>
                                <div style="font-weight:900; color:#334155; margin-top:0.35rem;">{{ $packageName }}</div>
                            </td>

                            <td style="font-weight:900; color:#0f172a;">
                                {{ $currency }} {{ number_format($booking->total_amount ?? 0, 2) }}
                            </td>

                            <td>
                                <span class="pill" style="background:{{ $bg }}; color:{{ $text }}; border:1px solid {{ $border }};">
                                    {{ $label }}
                                </span>
                            </td>

                            <td style="color:#64748b; font-size:0.8rem; font-weight:700;">
                                {{ ! empty($booking->created_at) ? \Carbon\Carbon::parse($booking->created_at)->format('d/m/Y') : '-' }}
                                <br>
                                {{ ! empty($booking->created_at) ? \Carbon\Carbon::parse($booking->created_at)->format('h:i A') : '' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:#94a3b8; padding:2rem 0;">
                                Tiada aktiviti tempahan buat masa ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="dashboard-panel calendar-card">
            <div class="panel-head">
                <div>
                    <h2 class="panel-title">Calendar</h2>
                    <p class="panel-subtitle">Upcoming bookings and blocked dates.</p>
                </div>
            </div>

            <div class="calendar-top">
                <div class="calendar-month">{{ $firstDay->format('F Y') }}</div>
                <div class="calendar-nav">
    <a href="{{ route('admin.dashboard', ['month' => $previousMonthDate->month, 'year' => $previousMonthDate->year]) }}">
        &lt;
    </a>

    <a href="{{ route('admin.dashboard', ['month' => $nextMonthDate->month, 'year' => $nextMonthDate->year]) }}">
        &gt;
    </a>
</div>
            </div>

            <div class="calendar-grid">
                @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $dayName)
                    <div class="calendar-day-name">{{ $dayName }}</div>
                @endforeach

                @foreach($days as $day)
                    @php
                        $dateKey = $day->format('Y-m-d');
                        $isCurrentMonth = $day->month === $month;
                        $dayBookings = $bookingEvents[$dateKey] ?? [];
                        $isHoliday = $holidayDates->has($dateKey);
                    @endphp

                    <div class="calendar-cell {{ $isCurrentMonth ? '' : 'muted' }}">
                        <div class="calendar-number">{{ $day->day }}</div>

                        @if($isHoliday && $isCurrentMonth)
                            <div class="calendar-holiday">
                                Public Holiday
                            </div>
                        @endif

                        @foreach(array_slice($dayBookings, 0, 2) as $event)
                            @php
                                $packageName = $event->package_name ?? ('Package ' . ($event->package_id ?? '-'));
                                $colors = $packageColor($packageName);
                            @endphp

                            <div class="calendar-event"
                                style="background:{{ $colors['bg'] }}; border-left-color:{{ $colors['border'] }}; color:{{ $colors['text'] }};">
                                <span>{{ $packageName }}</span>
                                <span>{{ $event->total_pax ?? 1 }} Pax</span>
                            </div>
                        @endforeach

                        @if(count($dayBookings) > 2)
                            <div style="font-size:0.65rem; color:#64748b; font-weight:900; margin-top:0.25rem;">
                                +{{ count($dayBookings) - 2 }} more
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="calendar-legend">
                <div><span class="legend-dot" style="background:#22c55e;"></span>Package A</div>
                <div><span class="legend-dot" style="background:#f59e0b;"></span>Package B</div>
                <div><span class="legend-dot" style="background:#8b5cf6;"></span>Package C</div>
                <div><span class="legend-dot" style="background:#dc2626;"></span>Public Holiday</div>
            </div>
        </div>
    </div>
</div>
@endsection