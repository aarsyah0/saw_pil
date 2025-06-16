<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekapPenilaianTahunan;

class RekapTahunanController extends Controller
{
    public function index()
    {
        // Ambil semua tahun yang tersedia dari tabel
        $years = RekapPenilaianTahunan::select('tahun')
                    ->distinct()
                    ->orderByDesc('tahun')
                    ->pluck('tahun');

        return view('admin.rekap.index', compact('years'));
    }

   public function show($tahun)
{
    $rekap = \App\Models\RekapPenilaianTahunan::with('peserta.user')
                ->where('tahun', $tahun)
                ->orderByDesc('total_akhir') // ✅ urut dari yang tertinggi
                ->get();

    return view('admin.rekap.show', compact('rekap', 'tahun'));
}

}
