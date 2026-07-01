<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    // Menggunakan UUID string, bukan nombor auto-increment
    public $incrementing = false;
    protected $keyType = 'string';

    // 🌟 PENTING: Tutup fungsi timestamps automatik Laravel supaya dia tidak cari kolum updated_at!
    public $timestamps = false;

    // SINKRONISASI: Hanya kolum ini sahaja yang wujud di table public.users korang
    protected $fillable = [
        'id',
        'full_name',
        'email',
    ];

    protected $hidden = [
        'remember_token',
    ];

    public function getNameAttribute($value): string
    {
        return $this->attributes['full_name'] ?? $this->attributes['name'] ?? $value ?? '';
    }

    public function setNameAttribute($value): void
    {
        $this->attributes['full_name'] = $value;
    }
}