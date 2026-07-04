@extends('layouts.admin-master')

@section('page-title', 'Booking Requests')

@section('content')

    <div class="card-premium" id="bookings-sec">
        <h2 class="card-title">Booking Requests</h2>
        <p class="card-subtitle">Review and manage booking requests received from Edu-Forest customers.</p>

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
                        @php
                            $paymentStatus = strtolower($booking->payment_status ?? 'pending');
                            $currency = strtolower($booking->selected_category ?? '') === 'international' ? 'USD' : 'RM';
                            $packageName = $booking->package_name ?? ('Package ' . ($booking->package_id ?? ''));
                        @endphp

                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">
                                    {{ $booking->client_name ?? 'No Name' }}
                                </div>

                                <div style="font-size: 11px; color: #94a3b8; font-family: 'Montserrat'; margin-top: 2px;">
                                    ID: {{ $booking->id }}
                                </div>
                            </td>

                            <td>
                                <span class="badge-category" style="margin-bottom: 4px;">
                                    {{ $booking->selected_category ?? 'PUBLIC' }}
                                </span>

                                <div style="font-size: 0.85rem; font-weight: 600; margin-top: 4px;">
                                    {{ $packageName }}
                                </div>
                            </td>

                            <td style="font-weight: 800; color: #0f172a; white-space: nowrap;">
                                {{ $currency }} {{ number_format($booking->total_amount ?? 0, 2) }}
                            </td>

                            <td style="min-width: 180px;">
                                @if($paymentStatus === 'approved')
                                    <span style="display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; background: #ecfdf5; color: #065f46; font-weight: 800; font-size: 12px; padding: 8px 16px; border-radius: 999px; border: 1px solid #a7f3d0;">
                                        Upcoming
                                    </span>
                                @elseif($paymentStatus === 'rejected')
                                    <span style="display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; background: #fef2f2; color: #991b1b; font-weight: 800; font-size: 12px; padding: 8px 16px; border-radius: 999px; border: 1px solid #fecaca;">
                                        Rejected
                                    </span>
                                @else
                                    <span style="display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; background: #fffbeb; color: #b45309; font-weight: 800; font-size: 12px; padding: 8px 16px; border-radius: 999px; border: 1px solid #fef3c7;">
                                        Pending Payment
                                    </span>
                                @endif
                            </td>

                            <td style="text-align: center; min-width: 230px;">
                                <div style="display: flex; flex-direction: column; gap: 0.55rem; align-items: center; justify-content: center;">
                                    <a href="{{ route('admin.bookings.show', $booking->id) }}"
                                    class="btn-action-success"
                                    style="text-decoration: none; width: 160px; text-align: center;">
                                        View Details
                                    </a>

                                    @if($paymentStatus !== 'rejected')
                                        <div style="display: flex; gap: 0.5rem; align-items: center; justify-content: center;">
                                            @if($paymentStatus !== 'approved')
                                                <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Approve this booking? The selected date will be marked as fully booked.')">
                                                    @csrf
                                                    @method('PATCH')

                                                    <input type="hidden" name="status" value="approved">

                                                    <button type="submit" class="btn-action-success">
                                                        Approve
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Reject this booking? The selected date will become available again.')">
                                                @csrf
                                                @method('PATCH')

                                                <input type="hidden" name="status" value="rejected">

                                                <button type="submit" class="btn-action-danger">
                                                    Reject
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:#94a3b8; padding: 2rem 0;">
                                Tiada permohonan tempahan buat masa ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection