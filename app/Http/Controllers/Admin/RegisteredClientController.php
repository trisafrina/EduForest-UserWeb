<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class RegisteredClientController extends Controller
{
    public function index()
    {
        $clients = DB::table('users')
            ->leftJoin('profiles', 'users.id', '=', 'profiles.id')
            ->select(
                DB::raw("COALESCE(NULLIF(profiles.full_name, ''), users.email) as client_name"),
                'users.email as client_email',
                DB::raw("NULLIF(profiles.phone_number, '') as client_number"),
                DB::raw("NULLIF(profiles.user_category, '') as selected_category"), 
            )
            ->orderBy('users.created_at', 'desc')
            ->get();

        return view('admin.registered-clients', compact('clients'));
    }
}