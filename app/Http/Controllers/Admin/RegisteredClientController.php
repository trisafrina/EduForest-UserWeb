<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisteredClientController extends Controller
{
    public function index()
    {
        // Mengambil data klien yang unik mengikut emel
        $clients = DB::table('bookings')
            ->select('client_name', 'client_email', 'client_number', 'selected_category', DB::raw('MAX(created_at) as registered_at'))
            ->groupBy('client_name', 'client_email', 'client_number', 'selected_category')
            ->orderBy('registered_at', 'desc')
            ->get();

        // Hantar data $clients ke fail view admin/registered-clients.blade.php
        return view('admin.registered-clients', compact('clients'));
    }
}