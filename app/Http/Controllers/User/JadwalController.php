<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\SchedulePiBi;

class JadwalController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Ambil hanya jadwal PI & BI untuk peserta yang sedang login
        $schedules = SchedulePiBi::where('peserta_id', $userId)
            ->orderBy('tanggal')
            ->get();

        return view('user.jadwal', compact('schedules'));
    }
}
