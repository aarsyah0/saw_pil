<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenilaianAkhir;
use App\Models\BobotKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PenilaianAkhirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar perangkingan peserta berdasarkan SAW.
     */
    public function index()
    {
    // Ambil bobot
        $bobot = BobotKriteria::all()->pluck('bobot', 'nama_kriteria')->toArray();
    // Ambil data penilaian (normal)
    $raw = PenilaianAkhir::with('peserta')->get();

    // Bangun matrix
    $matrix = $raw->map(function($row) use($bobot) {
        $norm = [
            'CU' => $row->skor_cu_normal,
            'PI' => $row->skor_pi_normal,
            'BI' => $row->skor_bi_normal,
        ];
        $weighted = [
            'CU' => round($norm['CU'] * $bobot['CU'],4),
            'PI' => round($norm['PI'] * $bobot['PI'],4),
            'BI' => round($norm['BI'] * $bobot['BI'],4),
        ];
        return [
            'peserta'   => $row->peserta->user->name,
            'norm'      => $norm,
            'weighted'  => $weighted,
        ];
    });
        // 1. Ambil bobot kriteria


        // 2. Ambil skor normal dan hitung total SAW di aplikasi
        $data = PenilaianAkhir::with('peserta')
            ->get()
            ->map(function($row) use($bobot) {
                $row->computed_total = round(
                    $row->skor_cu_normal * ($bobot['CU'] ?? 0)
                  + $row->skor_pi_normal * ($bobot['PI'] ?? 0)
                  + $row->skor_bi_normal * ($bobot['BI'] ?? 0)
                , 4);
                return $row;
            })
            // 3. Urutkan descending by computed_total
            ->sortByDesc('computed_total')
            // 4. Tambahkan rank
            ->values()
            ->map(function($row, $idx) {
                $row->rank = $idx + 1;
                return $row;
            });

            return view('admin.penilaian_akhir', compact('data','matrix','bobot'));
    }
}
