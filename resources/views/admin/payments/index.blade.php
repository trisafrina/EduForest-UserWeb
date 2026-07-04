@extends('layouts.admin-master')

@section('page-title', 'Payment Verification')

@section('content')

    <div class="card-premium" id="payments-sec">
        <h2 class="card-title">Payment Verification</h2>
        <p class="card-subtitle">Check the uploaded payment receipt and confirm the customer's booking transaction.</p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Client Information</th>
                        <th>Package Details</th>
                        <th>Total Amount</th>
                        <th>Client Receipt</th>
                        <th style="text-align: center;">Admin Invoice</th>
                        <th style="text-align: center;">Verification Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($payments as $payment)
                        @php
                            $paymentStatus = strtolower($payment->payment_status ?? 'pending');
                            $isApproved = $paymentStatus === 'approved' || $paymentStatus === 'verified';
                            $isRejected = $paymentStatus === 'rejected';
                            $currency = strtolower($payment->selected_category ?? '') === 'international' ? 'USD' : 'RM';
                        @endphp

                        <tr>
                            <td>
                                <div style="font-weight: 700; color: #0f172a;">
                                    {{ $payment->client_name ?? 'No Name' }}
                                </div>

                                <div style="font-size: 11px; color: #94a3b8; font-family: 'Montserrat'; margin-top: 2px;">
                                    {{ $payment->client_email ?? '-' }}
                                </div>

                                <div style="font-size: 11px; color: #2f855a; font-weight: 800; margin-top: 4px;">
                                    Ref: {{ $payment->reference_number ?? '-' }}
                                </div>
                            </td>

                            <td>
                                <span class="badge-category" style="margin-bottom: 4px;">
                                    {{ $payment->selected_category ?? 'PUBLIC' }}
                                </span>

                                <div style="font-size: 0.85rem; font-weight: 600; margin-top: 4px;">
                                    {{ $payment->package_name ?? ('Package ' . ($payment->package_id ?? '')) }}
                                </div>
                            </td>

                            <td style="font-weight: 800; color: #0f172a; white-space: nowrap;">
                                {{ $currency }} {{ number_format($payment->total_amount ?? 0, 2) }}
                            </td>

                            <td style="min-width: 190px;">
                                @if(!empty($payment->receipt_url) && $payment->receipt_url !== 'pending_upload_local')
                                    <a href="{{ $payment->receipt_url }}"
                                       target="_blank"
                                       style="display: inline-block; color: #2f855a; font-weight: 800; text-decoration: none; font-size: 0.9rem;">
                                        View Receipt
                                    </a>
                                @else
                                    <span style="display: inline-block; color: #ef4444; font-weight: 800; font-size: 0.9rem; line-height: 1.25;">
                                        Receipt upload failed / missing
                                    </span>
                                @endif

                                <div style="margin-top: 8px;">
                                    @if($isApproved)
                                        <span style="display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; background: #ecfdf5; color: #065f46; font-weight: 800; font-size: 12px; padding: 8px 16px; border-radius: 999px; border: 1px solid #a7f3d0;">
                                            Verified
                                        </span>
                                    @elseif($isRejected)
                                        <span style="display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; background: #fef2f2; color: #991b1b; font-weight: 800; font-size: 12px; padding: 8px 16px; border-radius: 999px; border: 1px solid #fecaca;">
                                            Rejected
                                        </span>
                                    @else
                                        <span style="display: inline-flex; align-items: center; justify-content: center; white-space: nowrap; background: #fffbeb; color: #b45309; font-weight: 800; font-size: 12px; padding: 8px 16px; border-radius: 999px; border: 1px solid #fef3c7;">
                                            Pending Approval
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <td style="text-align: center; vertical-align: middle; min-width: 230px;">
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.55rem;">
                                    @if(!empty($payment->invoice_url))
                                        <a href="{{ $payment->invoice_url }}"
                                           target="_blank"
                                           style="display: inline-block; color: #2f855a; font-weight: 800; text-decoration: none; font-size: 0.9rem;">
                                            View Invoice
                                        </a>

                                        <div style="font-size: 11px; color: #64748b;">
                                            {{ $payment->invoice_number ?? '' }}
                                        </div>
                                    @else
                                        <form action="{{ route('admin.payments.uploadInvoice', $payment->payment_id) }}"
                                              method="POST"
                                              enctype="multipart/form-data"
                                              style="display: flex; flex-direction: column; align-items: center; gap: 0.55rem;">
                                            @csrf

                                            <input
                                                type="file"
                                                name="invoice_file"
                                                accept=".pdf,.jpg,.jpeg,.png"
                                                required
                                                style="font-size: 12px; max-width: 190px;"
                                            >

                                            <button type="submit" class="btn-action-success">
                                                Upload Invoice
                                            </button>
                                        </form>

                                        @if(session('invoice_payment_id') === $payment->payment_id)
                                            @error('invoice_file_' . $payment->payment_id)
                                                <div style="color: #dc2626; font-size: 12px; font-weight: 700; margin-top: 6px;">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        @endif
                                    @endif
                                </div>
                            </td>

                            <td style="text-align: center; min-width: 180px;">
                                <form action="{{ route('admin.payments.verify', $payment->payment_id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Sahkan pembayaran ini?')">
                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="btn-action-success"
                                            {{ $isApproved ? 'disabled' : '' }}>
                                        {{ $isApproved ? 'Verified' : 'Verify Payment' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; color:#94a3b8; padding: 2rem 0;">
                                Tiada pembayaran untuk disahkan buat masa ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection