<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuSubmission;
use App\Models\PenilaianAkhir;
use App\Models\PesertaProfile;
use App\Models\BobotKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenilaianAkhirController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan daftar perangkingan peserta berdasarkan SAW dengan normalisasi CU "fresh",
     * namun mempertahankan nilai PI & BI yang sudah tersimpan.
     */
    public function index()
    {
        // 1. Ambil bobot kriteria
        $bobot = BobotKriteria::all()->pluck('bobot', 'nama_kriteria')->toArray();

        // 2. Hitung total_mentah dari CU untuk setiap peserta yang approved
        $cuTotals = CuSubmission::query()
            ->where('status', CuSubmission::STATUS_APPROVED)
            ->select('peserta_id', DB::raw('SUM(skor) as total_mentah'))
            ->groupBy('peserta_id')
            ->get();

        // 3. Cari nilai maksimal total_mentah
        $maxRaw = $cuTotals->max('total_mentah') ?: 1;

        // 4. Ambil profil peserta dan data PenilaianAkhir tersimpan
        $pesertaIds = $cuTotals->pluck('peserta_id')->toArray();
        $profiles = PesertaProfile::with('user')
            ->whereIn('user_id', $pesertaIds)
            ->get()
            ->keyBy('user_id');
        $stored = PenilaianAkhir::whereIn('peserta_id', $pesertaIds)
            ->get()
            ->keyBy('peserta_id');

        // 5. Bangun data final
        $data = $cuTotals->map(function($item) use ($bobot, $maxRaw, $profiles, $stored) {
            $pid = $item->peserta_id;
            $profile = $profiles->get($pid);
            $pa = $stored->get($pid);

            // Norm CU fresh
            $normCu = round($item->total_mentah / $maxRaw, 4);
            // Pertahankan PI & BI dari db jika ada
            $normPi = $pa?->skor_pi_normal ?? 0.0;
            $normBi = $pa?->skor_bi_normal ?? 0.0;

            $norm = ['CU' => $normCu, 'PI' => $normPi, 'BI' => $normBi];
            $weighted = [
                'CU' => round($normCu * ($bobot['CU'] ?? 0), 4),
                'PI' => round($normPi * ($bobot['PI'] ?? 0), 4),
                'BI' => round($normBi * ($bobot['BI'] ?? 0), 4),
            ];
            $computed = array_sum($weighted);

            return (object) [
                'peserta'        => $profile,
                'norm'           => $norm,
                'weighted'       => $weighted,
                'computed_total' => $computed,
                'rank'           => 0,
            ];
        })
        ->sortByDesc('computed_total')
        ->values();

        // 6. Update tabel penilaian_akhir dan tetapkan rank
        $data->each(function($row, $idx) use ($bobot) {
            $pid = $row->peserta->user_id;
            $pa = PenilaianAkhir::firstOrNew(['peserta_id' => $pid]);
            $pa->skor_cu_normal = $row->norm['CU'];
            $pa->skor_pi_normal = $row->norm['PI'];
            $pa->skor_bi_normal = $row->norm['BI'];
            $pa->total_akhir    = round(
                $row->norm['CU'] * ($bobot['CU'] ?? 0)
              + $row->norm['PI'] * ($bobot['PI'] ?? 0)
              + $row->norm['BI'] * ($bobot['BI'] ?? 0)
            , 4);
            $pa->save();

            $row->rank = $idx + 1;
        });

        // 7. Siapkan matrix untuk view
        $matrix = $data->map(function($row) {
            return [
                'peserta'  => $row->peserta->user->name,
                'norm'     => $row->norm,
                'weighted' => $row->weighted,
            ];
        });

        return view('admin.penilaian_akhir', [
            'data'   => $data,
            'matrix' => $matrix,
            'bobot'  => $bobot,
        ]);
    }
}
