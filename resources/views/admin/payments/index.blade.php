@extends('layouts.admin-master')

@section('page-title', 'Payment Verification')

@section('content')

    <div class="card-premium" id="payments-sec">
        <h2 class="card-title">Payment Verification</h2>
        <p class="card-subtitle">Semak resit pembayaran yuran komitmen dan sahkan transaksi tempahan pelanggan.</p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Client Information</th>
                        <th>Package Details</th>
                        <th>Total Amount</th>
                        <th>Client Receipt</th>
                        <th style="text-align: center;">Verification Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <div style="font-weight: 600; color: #0f172a;">{{ $payment->client_name ?? 'No Name' }}</div>
                                <div style="font-size: 11px; color: #94a3b8; font-family:monospace; margin-top: 2px;">ID: {{ $payment->id }}</div>
                            </td>
                            <td>
                                <span class="badge-category" style="margin-bottom: 4px;">{{ $payment->selected_category ?? 'PUBLIC' }}</span>
                                <div style="font-size: 0.85rem; font-weight: 500;">{{ $payment->package_details ?? '-' }}</div>
                            </td>
                            <td style="font-weight: 700; color: #0f172a;">RM {{ number_format($payment->total_amount ?? 0, 2) }}</td>
                            <td>
                                @if(!empty($payment->receipt_url))
                                    <a href="{{ $payment->receipt_url }}" target="_blank" style="color: #2563eb; font-weight: 600; text-decoration: none; font-size: 0.85rem;">📄 View Receipt</a>
                                @else
                                    <span style="color: #94a3b8; font-style: italic; font-size: 0.85rem;">No receipt uploaded</span>
                                @endif

                                <div style="margin-top: 6px;">
                                    @if(($payment->status ?? 'pending') === 'Paid' || ($payment->status ?? '') === 'paid')
                                        <span style="background: #ecfdf5; color: #065f46; font-weight: 700; font-size: 11px; padding: 2px 6px; border-radius: 4px; border: 1px solid #a7f3d0;">🟢 Verified</span>
                                    @else
                                        <span style="background: #fffbeb; color: #b45309; font-weight: 700; font-size: 11px; padding: 2px 6px; border-radius: 4px; border: 1px solid #fef3c7;">🟡 Pending</span>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" onsubmit="return confirm('Sahkan pembayaran ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-action-success">Verify Payment</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:#94a3b8; padding: 2rem 0;">Tiada pembayaran untuk disahkan buat masa ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection