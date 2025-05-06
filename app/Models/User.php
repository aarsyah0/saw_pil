<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use App\Models\PesertaProfile;
use App\Models\AdminProfile;
use App\Models\JuriProfile;

class User extends Authenticatable
{
    use HasFactory ,Notifiable;

    protected $fillable = [
        'name',         // ubah dari 'nama' menjadi 'name'
        'email',
        'password',
        'role',
        'email_verified_at',
        'remember_token',
    ];

    // …

    // (opsional) relasi ke PesertaProfile
    public function pesertaProfile()
    {
        return $this->hasOne(PesertaProfile::class, 'user_id', 'id');
    }

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function isAdmin()
    {
        return Auth::user()->role === 'admin'; // Sesuaikan dengan kolom di database
    }

    public static function isUser(): bool
    {
        return Auth::user()->role === 'users'; // Sesuaikan dengan kolom di database
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }
    public function isJuri()
    {
        return $this->role === 'juri';
    }
    public function schedulePiBis()
{
    return $this->belongsToMany(SchedulePiBi::class, 'schedule_pibi_user', 'user_id', 'schedule_pibi_id');
}
public function adminProfile()
{
    return $this->hasOne(AdminProfile::class, 'user_id');
}

public function juriProfile()
    {
        return $this->hasOne(JuriProfile::class, 'user_id');
    }

    public function profile()
    {
        if ($this->role === 'admin') {
            return $this->adminProfile;
        }

        if ($this->role === 'juri') {
            return $this->juriProfile;
        }

        if ($this->role === 'peserta') {
            return $this->pesertaProfile;
        }

        return null;
    }
}
