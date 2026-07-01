@extends('layouts.admin-master')

@section('page-title')
    Welcome back, <span class="header-user">{{ Auth::user()->full_name ?? session('admin_name', 'Admin') }}</span>
@endsection

@section('content')

    <div class="stat-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4; color:#046307;"><i class="fa-solid fa-users"></i></div>
            <div class="stat-value">{{ $totalClients ?? 0 }}</div>
            <div class="stat-label">Registered Clients</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb; color:#b45309;"><i class="fa-solid fa-file-invoice"></i></div>
            <div class="stat-value">{{ $pendingBookings ?? 0 }}</div>
            <div class="stat-label">Pending Booking Requests</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff; color:#1d4ed8;"><i class="fa-solid fa-receipt"></i></div>
            <div class="stat-value">{{ $pendingPayments ?? 0 }}</div>
            <div class="stat-label">Payments Awaiting Verification</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fdf2f8; color:#be185d;"><i class="fa-solid fa-calendar-days"></i></div>
            <div class="stat-value">{{ $blockedDatesCount ?? 0 }}</div>
            <div class="stat-label">Calendar Restrictions Active</div>
        </div>
    </div>

    <div class="card-premium">
        <h2 class="card-title">Recent Booking Activity</h2>
        <p class="card-subtitle">Senarai permohonan tempahan terkini daripada pelanggan Edu-Forest.</p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Client Information</th>
                        <th>Package Details</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(($recentBookings ?? []) as $booking)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #0f172a;">{{ $booking->client_name ?? 'No Name' }}</div>
                                <div style="font-size: 11px; color: #94a3b8; font-family:monospace; margin-top: 2px;">ID: {{ $booking->id }}</div>
                            </td>
                            <td>
                                <span class="badge-category" style="margin-bottom: 4px;">{{ $booking->selected_category ?? 'PUBLIC' }}</span>
                            </td>
                            <td style="font-weight: 700; color: #0f172a;">RM {{ number_format($booking->total_amount ?? 0, 2) }}</td>
                            <td>
                                @if(($booking->status ?? 'pending') === 'approved' || ($booking->status ?? '') === 'paid')
                                    <span style="background: #ecfdf5; color: #065f46; font-weight: 700; font-size: 11px; padding: 2px 6px; border-radius: 4px; border: 1px solid #a7f3d0;">🟢 {{ ucfirst($booking->status) }}</span>
                                @elseif(($booking->status ?? '') === 'rejected')
                                    <span style="background: #fef2f2; color: #991b1b; font-weight: 700; font-size: 11px; padding: 2px 6px; border-radius: 4px; border: 1px solid #fee2e2;">🔴 Rejected</span>
                                @else
                                    <span style="background: #fffbeb; color: #b45309; font-weight: 700; font-size: 11px; padding: 2px 6px; border-radius: 4px; border: 1px solid #fef3c7;">🟡 Pending</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; color:#94a3b8; padding: 2rem 0;">Tiada aktiviti tempahan buat masa ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection