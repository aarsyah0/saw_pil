<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardJuriController extends Controller
{
    public function index()
    {
        $juriId = Auth::id();

        // Hitung jumlah peserta unik yang lolos CU
        $passedCount = DB::table('cu_selection')
            ->where('status_lolos', 'lolos')
            ->distinct('peserta_id')
            ->count('peserta_id');

        // Ambil jadwal PI/BI dari pivot schedule_pi_bi_juri -> jadwal utama schedule_pi_bi
        $schedules = DB::table('schedule_pi_bi_juri as spbj')
            ->join('schedule_pi_bi as spb', 'spbj.schedule_id', '=', 'spb.id')
            ->join('users as u', 'spb.peserta_id', '=', 'u.id')
            ->select('spb.id', 'u.name as peserta_name', 'spb.tanggal', 'spb.lokasi')
            ->where('spbj.juri_id', $juriId)
            ->orderBy('spb.tanggal')
            ->get();

        return view('juri.dashboard', compact('passedCount', 'schedules'));
    }
}
