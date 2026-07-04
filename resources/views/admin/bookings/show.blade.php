@extends('layouts.admin-master')

@section('page-title', 'Booking Request Details')

@section('content')
<div class="card-premium booking-details-container">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem;">
        <h2 style="color: #0f172a; margin: 0;">Booking Details #{{ $booking->reference_number ?? 'Tiada No. Rujukan' }}</h2>
        <span class="badge" style="padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600; background: #fef3c7; color: #d97706;">
            {{ strtoupper($booking->status) }}
        </span>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3 style="color: #046307; margin-bottom: 1rem;">👤 Client Information</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; padding: 0.5rem 0; color: #64748b;">Full Name:</td>
                <td style="font-weight: 600; color: #1e293b;">{{ $booking->client_name }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Client Email:</td>
                <td>{{ $booking->client_email }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Phone Number:</td>
                <td>{{ $booking->client_number }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Category:</td>
                <td><span style="background: #e2e8f0; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.85rem;">{{ $booking->selected_category }}</span></td>
            </tr>
        </table>
    </div>

    <div style="margin-bottom: 2rem;">
        <h3 style="color: #046307; margin-bottom: 1rem;">📅 Date & Pax Details</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; padding: 0.5rem 0; color: #64748b;">Check-in Date:</td>
                <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Check-out Date:</td>
                <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Total Participants:</td>
                <td style="font-weight: 600; color: #046307;">{{ $booking->total_pax }} people</td>
            </tr>
        </table>
    </div>
        
    </div>

    <div style="margin-top: 2rem;">
        <a href="{{ route('admin.bookings.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">← Kembali ke Senarai Permohonan</a>
    </div>

</div>
@endsection