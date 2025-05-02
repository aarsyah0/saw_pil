<?php
// app/Http/Middleware/UserMiddleware.php

// namespace App\Http\Middleware;
// use App\Models\User;
// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;

// class UserMiddleware
// {
//     public function handle(Request $request, Closure $next)
//     {
//         // if (Auth::check() && User::isUser()) {
//         //     return $next($request);
//         // }
//         if (Auth::check() && Auth::user()->role === 'user') {
//             return $next($request);
//         }
        
//         return redirect()->route('login')->with('error', 'You do not have access to this page.');
//     }
// }

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    public static function isAdmin()
    {
        return Auth::user()->role === 'admin'; // Sesuaikan dengan kolom di database
    }

    public static function isUser(): bool
    {
        return Auth::user()->role === 'user';
    }

    public static function isJuri(): bool
    {
        return Auth::user()->role === 'juri';
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class);
    }
}
