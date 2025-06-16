<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuSubmission;
use App\Models\PenilaianAkhir;
use App\Models\PesertaProfile;
use App\Models\PenilaianPiJuri;
use App\Models\PenilaianBiJuri;
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
    public function destroy($id)
{
    // 1. Temukan entri PenilaianAkhir berdasarkan ID
    $pa = PenilaianAkhir::findOrFail($id);
    $pesertaId = $pa->peserta_id;

    // 2. Hapus semua PenilaianPiJuri di mana schedule.peserta_id = $pesertaId
    PenilaianPiJuri::whereHas('schedule', function($query) use ($pesertaId) {
        $query->where('peserta_id', $pesertaId);
    })->delete();

    // 3. Hapus semua PenilaianBiJuri di mana schedule.peserta_id = $pesertaId
    PenilaianBiJuri::whereHas('schedule', function($query) use ($pesertaId) {
        $query->where('peserta_id', $pesertaId);
    })->delete();

    // 4. Hapus semua CU Submission yang sudah disetujui untuk peserta ini
    CuSubmission::where('peserta_id', $pesertaId)
        ->where('status', CuSubmission::STATUS_APPROVED)
        ->delete();

    // 5. Hapus entri PenilaianAkhir itu sendiri
    $pa->delete();

    return redirect()
        ->route('admin.penilaian-akhir.index')
        ->with('success', 'Penilaian Akhir, CU Submission, dan seluruh Penilaian PI & BI Juri berhasil dihapus.');
}
protected function simpanRekapitulasiTahunan($year = null)
{
    $currentYear = $year ?? date('Y');
    $penilaianList = \App\Models\PenilaianAkhir::all();

    foreach ($penilaianList as $pa) {
        $pid = $pa->peserta_id;

        // Ambil semua entri CU untuk peserta ini
        $cuList = \App\Models\CuSelection::where('peserta_id', $pid)->get();

        // Default status dan round
        $statusCu = 'pending';
        $round = 0;

        if ($cuList->isNotEmpty()) {
            // Ambil selection_round tertinggi
            $round = $cuList->max('selection_round');

            // Cari status_lolos sesuai urutan prioritas
            if ($cuList->contains('status_lolos', 'lolos')) {
                $statusCu = 'lolos';
            } elseif ($cuList->contains('status_lolos', 'gagal')) {
                $statusCu = 'gagal';
            } elseif ($cuList->contains('status_lolos', 'pending')) {
                $statusCu = 'pending';
            }
        }

        // Simpan rekap
        \App\Models\RekapPenilaianTahunan::updateOrCreate(
            ['peserta_id' => $pid, 'tahun' => $currentYear],
            [
                'skor_cu_normal'  => $pa->skor_cu_normal,
                'skor_pi_normal'  => $pa->skor_pi_normal,
                'skor_bi_normal'  => $pa->skor_bi_normal,
                'total_akhir'     => $pa->total_akhir,
                'status_cu'       => $statusCu,
                'selection_round' => $round,
            ]
        );
    }
}

public function rekapTahunan(Request $request)
{
    $this->simpanRekapitulasiTahunan();

    return redirect()->route('admin.penilaian-akhir.index')
        ->with('success', 'Rekapitulasi tahunan berhasil disimpan.');
}


}
