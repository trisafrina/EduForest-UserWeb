<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    // Mengarahkan Laravel menggunakan table 'packages' dari Supabase
    protected $table = 'packages';

    protected $fillable = ['activity_id', 'package_name', 'price_upsi', 'price_public', 'description'];
}