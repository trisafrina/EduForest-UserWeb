<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    // Mengarahkan Laravel menggunakan table 'bookings' dari Supabase
    protected $table = 'bookings';

    protected $fillable = [
        'user_id', 
        'package_id', 
        'check_in', 
        'check_out', 
        'pax', 
        'total_price', 
        'status', 
        'special_request'
    ];
}