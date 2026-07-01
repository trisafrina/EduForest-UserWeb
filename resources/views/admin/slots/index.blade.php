@extends('layouts.admin-master')

@section('page-title', 'Calendar Availability')

@section('content')

    <div class="card-premium" id="calendar-sec">
        <h2 class="card-title">Manage Calendar Availability</h2>
        <p class="card-subtitle">Kawal selia sekatan kalendar dinamik untuk paparan aplikasi klien.</p>

        <div class="grid-premium">
            <form action="{{ route('admin.slots.store') }}" method="POST" class="sub-card-form">
                @csrf
                <input type="hidden" name="block_type" id="block_type_input" value="fully_booked">

                <h3 class="sub-card-title">Block / Unblock Booking Date</h3>
                <div class="form-group">
                    <label>Select Target Date</label>
                    <input type="date" name="booking_date" required>
                </div>
                <div class="form-group">
                    <label>Holiday / Closure Reason (For Red Block Only)</label>
                    <input type="text" name="reason" placeholder="e.g. Cuti Hari Raya Aidilfitri">
                </div>

                <div class="btn-flex-group">
                    <button type="submit" onclick="document.getElementById('block_type_input').value='fully_booked'" class="btn-premium btn-premium-emerald">Set Fully Booked (Green)</button>
                    <button type="submit" onclick="document.getElementById('block_type_input').value='holiday'" class="btn-premium btn-premium-red">Set Holiday Block (Red)</button>
                </div>
            </form>

            <div class="sub-card-form" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 class="sub-card-title">Active Calendar Conditions</h3>

                    @if(isset($blockedDates) && $blockedDates->count() > 0)
                        @foreach($blockedDates as $date)
                            @if($date->status === 'fully_booked')
                                <div class="condition-item booked">
                                    <span>🟢 <strong>{{ \Carbon\Carbon::parse($date->booking_date)->format('F d, Y') }}</strong> - Booked (Package Locked)</span>
                                    <span style="font-size: 11px; font-weight: 600; color: #16a34a; background: #fff; padding: 2px 8px; border-radius: 4px;">Locked by System</span>
                                </div>
                            @else
                                <div class="condition-item holiday">
                                    <span>🔴 <strong>{{ \Carbon\Carbon::parse($date->booking_date)->format('F d, Y') }}</strong> - {{ $date->reason ?? 'Blocked (Holiday)' }}</span>
                                    <form action="{{ route('admin.slots.destroy', $date->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-inline-delete" onclick="return confirm('Padam sekatan tarikh ini?')">Delete</button>
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div style="text-align: center; color: #94a3b8; font-size: 0.85rem; padding: 2rem 0;">
                            Tiada sekatan tarikh yang aktif buat masa ini.
                        </div>
                    @endif
                </div>

                <div class="ux-notice-box">
                    <span style="font-weight: 700; color: #1e293b;">💡 Info Aliran Sistem:</span>
                    <span>• Slot <strong>Hijau</strong> dikawal sepenuhnya oleh status tempahan klien.</span>
                    <span>• Slot <strong>Merah</strong> boleh dipadam secara manual oleh Admin jika tarikh cuti dibatalkan.</span>
                </div>
            </div>
        </div>
    </div>

@endsection