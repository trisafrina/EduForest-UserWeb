@extends('layouts.admin-master')

@section('page-title', 'Booking Requests')

@section('content')

    <div class="card-premium" id="bookings-sec">
        <h2 class="card-title">Booking Requests</h2>
        <p class="card-subtitle">Semak dan urus permohonan tempahan yang diterima daripada pelanggan Edu-Forest.</p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Client Information</th>
                        <th>Package Details</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #0f172a;">{{ $booking->client_name ?? 'No Name' }}</div>
                                <div style="font-size: 11px; color: #94a3b8; font-family:monospace; margin-top: 2px;">ID: {{ $booking->id }}</div>
                            </td>
                            <td>
                                <span class="badge-category" style="margin-bottom: 4px;">{{ $booking->selected_category ?? 'PUBLIC' }}</span>
                                <div style="font-size: 0.85rem; font-weight: 500; margin-top: 4px;">{{ $booking->package_details ?? '-' }}</div>
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
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 0.5rem; align-items:center;">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn-action-success" style="text-decoration:none;">View Details</a>

                                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" onsubmit="return confirm('Sahkan kelulusan tempahan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="btn-action-success">Approve</button>
                                    </form>

                                    <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST" onsubmit="return confirm('Tolak tempahan ini?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="rejected">
                                        <button type="submit" class="btn-action-danger">Reject</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:#94a3b8; padding: 2rem 0;">Tiada permohonan tempahan buat masa ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection