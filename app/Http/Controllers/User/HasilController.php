<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CuSelection;
use App\Models\PenilaianAkhir;
use App\Models\PesertaProfile;
use App\Models\User;

class HasilController extends Controller
{
    /**
     * Tampilkan halaman hasil perhitungan.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil status CU selection terbaru untuk peserta ini
        $selection = CuSelection::where('peserta_id', $userId)
            ->latest('selection_round')
            ->first();

        // Jika peserta lolos, ambil ranking nilai akhir
        $rankings = collect();
        if ($selection && $selection->status_lolos === 'lolos') {
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
                    'u.name',
                    'penilaian_akhir.skor_cu_normal',
                    'penilaian_akhir.skor_pi_normal',
                    'penilaian_akhir.skor_bi_normal',
                    'penilaian_akhir.total_akhir',
                ])
                ->get();
        }

        return view('user.hasil', compact('selection', 'rankings'));
    }
}
