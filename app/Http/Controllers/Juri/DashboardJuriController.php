<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PenilaianAkhir;

class DashboardJuriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $juriId = Auth::id();

        // 1) Hitung jumlah peserta unik yang lolos CU
        $passedCount = DB::table('cu_selection')
            ->where('status_lolos', 'lolos')
            ->distinct('peserta_id')
            ->count('peserta_id');

        // 2) Ambil jadwal PI/BI untuk juri
        $schedules = DB::table('schedule_pi_bi_juri as spbj')
            ->join('schedule_pi_bi as spb', 'spbj.schedule_id', '=', 'spb.id')
            ->join('users as u', 'spb.peserta_id', '=', 'u.id')
            ->select('spb.id', 'u.name as peserta_name', 'spb.tanggal', 'spb.lokasi')
            ->where('spbj.juri_id', $juriId)
            ->orderBy('spb.tanggal', 'asc')
            ->get();

        // 3) Ambil ranking dari penilaian_akhir langsung (pakai total_akhir)
        $rankings = PenilaianAkhir::join('peserta_profile as pp', 'penilaian_akhir.peserta_id', '=', 'pp.user_id')
            ->join('users as u', 'pp.user_id', '=', 'u.id')
            ->whereIn('penilaian_akhir.peserta_id', function($q) {
                $q->select('peserta_id')
                  ->from('cu_selection')
                  ->where('status_lolos', 'lolos');
            })
            ->orderByDesc('penilaian_akhir.total_akhir')
            ->select([
                'penilaian_akhir.peserta_id',
                'u.name as peserta_name',
                'penilaian_akhir.skor_cu_normal',
                'penilaian_akhir.skor_pi_normal',
                'penilaian_akhir.skor_bi_normal',
                'penilaian_akhir.total_akhir',
            ])
            ->get();

        return view('juri.dashboard', compact('passedCount', 'schedules', 'rankings'));
    }
}
