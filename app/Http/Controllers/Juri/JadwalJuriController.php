<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalJuriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar jadwal penilaian untuk juri yang sedang login.
     */
    public function index()
    {
        $juriId = Auth::id();

        $schedules = DB::table('schedule_pi_bi_juri as spbj')
            ->join('schedule_pi_bi as spb', 'spbj.schedule_id', '=', 'spb.id')
            ->join('users as u', 'spb.peserta_id', '=', 'u.id')
            ->select(
                'spb.id',
                'u.name as peserta_name',
                'spb.tanggal',
                'spb.lokasi'
            )
            ->where('spbj.juri_id', $juriId)
            ->orderBy('spb.tanggal', 'asc')
            ->get();

        return view('juri.jadwaljuri', compact('schedules'));
    }
}
