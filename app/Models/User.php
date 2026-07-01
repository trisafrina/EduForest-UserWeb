<?php

namespace App\Models;

<<<<<<< HEAD
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
=======
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

<<<<<<< HEAD
#[Fillable(['full_name', 'email', 'password', 'is_admin'])]
#[Hidden(['password', 'remember_token'])]
=======
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
class User extends Authenticatable
{
    use HasFactory, Notifiable;

<<<<<<< HEAD
    // 1. Beritahu Laravel ID anda bukan jenis nombor menaik (auto-increment)
    public $incrementing = false;

    // 2. Set jenis data primary key kepada teks string (Sebab UUID adalah string)
    protected $keyType = 'string';

    // 3. Matikan timestamps automatik bawaan Laravel
    public $timestamps = false;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
=======
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
>>>>>>> 7bb485a8f19c9faa6fab2f862c49a614a8b99b29
    }
}