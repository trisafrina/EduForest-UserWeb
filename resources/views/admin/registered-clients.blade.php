@extends('layouts.admin-master')

@section('page-title', 'Registered Clients')

@section('content')

    <div class="card-premium" id="clients-sec">
        <h2 class="card-title">Registered Clients Profile</h2>
        <p class="card-subtitle">List of registered account profiles using the UCTC web system.</p>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email Address</th>
                        <th>Phone Number</th>
                        <th>User Category</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($clients as $client)
                        <tr>
                            <td style="font-weight: 600; color: #0f172a;">
    {{ $client->client_name ?? $client->client_email }}
</td>

<td>
    {{ $client->client_email }}
</td>

<td>
    {{ $client->client_number ?: 'Not completed yet' }}
</td>

<td>
    @if(!empty($client->selected_category))
        <span class="badge-category">
            {{ str_replace('_', ' ', $client->selected_category) }}
        </span>
    @else
        <span style="color:#94a3b8; font-weight:600;">
            Not completed yet
        </span>
    @endif
</td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align:center; color:#94a3b8; padding: 2rem 0;">Tiada klien berdaftar buat masa ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection