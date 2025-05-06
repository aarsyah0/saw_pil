<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar semua peserta.
     */
    public function index()
    {
        $peserta = DB::table('users as u')
            ->join('peserta_profile as pp', 'u.id', '=', 'pp.user_id')
            ->where('u.role', 'peserta')
            ->select(
                'u.id',
                'u.name',
                'pp.nim',
                'pp.program_studi',
                'pp.semester_ke'
            )
            ->orderBy('u.name')
            ->get();

        return view('juri.peserta.index', compact('peserta'));
    }

    /**
     * Tampilkan detail profile seorang peserta.
     */
    public function show($id)
    {
        $peserta = DB::table('users as u')
            ->join('peserta_profile as pp', 'u.id', '=', 'pp.user_id')
            ->where('u.role', 'peserta')
            ->where('u.id', $id)
            ->select(
                'u.id',
                'u.name',
                'u.email',
                'pp.nik',
                'pp.tempat_lahir',
                'pp.tanggal_lahir',
                'pp.nim',
                'pp.no_hp',
                'pp.program_pendidikan',
                'pp.program_studi',
                'pp.semester_ke',
                'pp.ipk',
                'pp.perguruan_tinggi',
                'pp.alamat_pt',
                'pp.email_pt'
            )
            ->first();

        if (! $peserta) {
            abort(404);
        }

        return view('juri.peserta.show', compact('peserta'));
    }
}
