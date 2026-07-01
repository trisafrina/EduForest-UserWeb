@extends('layouts.admin-master')

@section('page-title', 'Registered Clients')

@section('content')

    <div class="card-premium" id="clients-sec">
        <h2 class="card-title">Registered Clients Profile</h2>
        <p class="card-subtitle">Senarai profil akaun berdaftar yang menggunakan ekosistem aplikasi UCTC.</p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>User Category</th>
                        <th>Last Registered</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td style="font-weight: 600; color: #0f172a;">{{ $client->client_name ?? '-' }}</td>
                            <td>{{ $client->client_email ?? '-' }}</td>
                            <td>{{ $client->client_number ?? '-' }}</td>
                            <td><span class="badge-category">{{ $client->selected_category ?? 'PUBLIC' }}</span></td>
                            <td style="font-weight: 500;">{{ $client->registered_at ? \Carbon\Carbon::parse($client->registered_at)->format('d M Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; color:#94a3b8; padding: 2rem 0;">Tiada klien berdaftar buat masa ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection