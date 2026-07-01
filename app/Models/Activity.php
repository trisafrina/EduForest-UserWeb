<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    // Mengarahkan Laravel menggunakan table 'activities' dari Supabase
    protected $table = 'activities';

    // Membenarkan data diisi secara pukal
    protected $fillable = ['name', 'description', 'image', 'facilities'];
}