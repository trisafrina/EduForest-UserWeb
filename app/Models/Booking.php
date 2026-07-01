<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
<<<<<<< HEAD
    //
}
=======
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
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
