@extends('layouts.admin-master')

@section('page-title', 'Booking Request Details')

@section('content')
<div class="card-premium booking-details-container">
    
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 1rem;">
        <h2 style="color: #0f172a; margin: 0;">Butiran Tempahan #{{ $booking->reference_number ?? 'Tiada No. Rujukan' }}</h2>
        <span class="badge" style="padding: 0.5rem 1rem; border-radius: 9999px; font-weight: 600; background: #fef3c7; color: #d97706;">
            {{ strtoupper($booking->status) }}
        </span>
    </div>

    {{-- Maklumat Klien --}}
    <div style="margin-bottom: 2rem;">
        <h3 style="color: #046307; margin-bottom: 1rem;">👤 Maklumat Pelanggan</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; padding: 0.5rem 0; color: #64748b;">Nama Penuh:</td>
                <td style="font-weight: 600; color: #1e293b;">{{ $booking->client_name }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Emel Klien:</td>
                <td>{{ $booking->client_email }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">No. Telefon:</td>
                <td>{{ $booking->client_number }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Kategori:</td>
                <td><span style="background: #e2e8f0; padding: 0.2rem 0.6rem; border-radius: 4px; font-size: 0.85rem;">{{ $booking->selected_category }}</span></td>
            </tr>
        </table>
    </div>

    {{-- Maklumat Slot & Tarikh --}}
    <div style="margin-bottom: 2rem;">
        <h3 style="color: #046307; margin-bottom: 1rem;">📅 Butiran Tarikh & Pax</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="width: 30%; padding: 0.5rem 0; color: #64748b;">Tarikh Daftar Masuk:</td>
                <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Tarikh Daftar Keluar:</td>
                <td style="font-weight: 600;">{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 0.5rem 0; color: #64748b;">Jumlah Peserta (Total Pax):</td>
                <td style="font-weight: 600; color: #046307;">{{ $booking->total_pax }} orang</td>
            </tr>
        </table>
    </div>

    {{-- Bahagian Lampiran Dokumen PDF Senarai Nama --}}
    <div style="background: #f8fafc; padding: 1.5rem; border-radius: 8px; border: 1px dashed #cbd5e1;">
        <h4 style="margin-top: 0; margin-bottom: 0.5rem; color: #334155;">📄 Dokumen Lampiran Klien</h4>
        <p style="font-size: 0.9rem; color: #64748b; margin-bottom: 1rem;">Klien berkumpulan diwajibkan memuat naik senarai nama penuh ahli yang menyertai.</p>
        
        @if(!empty($booking->participant_list_path))
            {{-- Butang untuk buka PDF di tab baru jika ada data path --}}
            <a href="{{ $booking->participant_list_path }}" target="_blank" 
            style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: #046307; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; transition: background 0.2s;"
            onmouseover="this.style.background='#034d05'" onmouseout="this.style.background='#046307'">
                👁️ Lihat & Muat Turun Senarai Peserta (PDF)
            </a>
        @else
            {{-- Keadaan jika path kosong/null --}}
            <div style="color: #94a3b8; font-style: italic; font-size: 0.9rem;">
                ⚠️ Tiada dokumen PDF dilampirkan oleh klien untuk tempahan ini.
            </div>
        @endif
    </div>

    {{-- Butang Kembali --}}
    <div style="margin-top: 2rem;">
        <a href="{{ route('admin.bookings.index') }}" style="color: #64748b; text-decoration: none; font-size: 0.9rem;">← Kembali ke Senarai Permohonan</a>
    </div>

</div>
@endsection