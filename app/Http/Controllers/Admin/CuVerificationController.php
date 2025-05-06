<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuSubmission;
use App\Models\PenilaianAkhir;
use App\Models\CuSelection;
use App\Models\KategoriCu;
use App\Models\BobotKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CuVerificationController extends Controller
{
    public function index()
    {
        // Ringkasan CU yang sudah disetujui
        $rows = DB::table('cu_submission as cs')
            ->join('kategori_cu as kc', 'cs.kategori_cu_id', '=', 'kc.id')
            ->join('peserta_profile as pp', 'cs.peserta_id', '=', 'pp.user_id')
            ->join('users as u', 'pp.user_id', '=', 'u.id')
            ->where('cs.status', CuSubmission::STATUS_APPROVED)
            ->select(
                'cs.peserta_id',
                'u.name',
                DB::raw('COALESCE(SUM(CASE WHEN kc.bidang_id = 1 THEN cs.skor END),0) AS Kompetisi'),
                DB::raw('COALESCE(SUM(CASE WHEN kc.bidang_id = 2 THEN cs.skor END),0) AS Pengakuan'),
                DB::raw('COALESCE(SUM(CASE WHEN kc.bidang_id = 3 THEN cs.skor END),0) AS Penghargaan'),
                DB::raw('COALESCE(SUM(CASE WHEN kc.bidang_id = 4 THEN cs.skor END),0) AS Karir_Organisasi'),
                DB::raw('COALESCE(SUM(CASE WHEN kc.bidang_id = 5 THEN cs.skor END),0) AS Hasil_Karya'),
                DB::raw('COALESCE(SUM(CASE WHEN kc.bidang_id = 6 THEN cs.skor END),0) AS PAK'),
                DB::raw('COALESCE(SUM(CASE WHEN kc.bidang_id = 7 THEN cs.skor END),0) AS Kewirausahaan'),
                DB::raw('SUM(cs.skor) AS total_mentah')
            )
            ->groupBy('cs.peserta_id', 'u.name')
            ->get();

        $maxRaw = $rows->max('total_mentah') ?: 1;

        // Transformasi: sertakan semua bidang agar Blade dapat mengakses properti
        $rows->transform(function ($r) use ($maxRaw) {
            return (object) [
                'peserta_id'       => $r->peserta_id,
                'name'             => $r->name,
                'Kompetisi'        => $r->Kompetisi,
                'Pengakuan'        => $r->Pengakuan,
                'Penghargaan'      => $r->Penghargaan,
                'Karir_Organisasi' => $r->Karir_Organisasi,
                'Hasil_Karya'      => $r->Hasil_Karya,
                'PAK'              => $r->PAK,
                'Kewirausahaan'    => $r->Kewirausahaan,
                'total_mentah'     => $r->total_mentah,
                'normalized'       => round($r->total_mentah / $maxRaw, 4),
            ];
        });

        // Ambil semua submission yang masih pending
        $submissions = CuSubmission::with(['peserta', 'kategori'])
            ->where('status', CuSubmission::STATUS_PENDING)
            ->get();

        return view('admin.verifikasiberkas', compact('rows', 'submissions'));
    }

    public function approve(CuSubmission $submission)
    {
        DB::transaction(function () use ($submission) {
            // 1) tandai approved
            $submission->update([
                'status'      => CuSubmission::STATUS_APPROVED,
                'reviewed_at' => now(),
            ]);

            // 2) kumpulkan semua approved untuk peserta ini
            $approved = CuSubmission::with('kategori')
                ->where('peserta_id', $submission->peserta_id)
                ->where('status', CuSubmission::STATUS_APPROVED)
                ->get();

            // 3) ambil top 4 per bidang, lalu top 10 overall
            $byBidang = $approved->groupBy(fn($i) => $i->kategori->bidang_id);
            $selected = collect();
            foreach ($byBidang as $grp) {
                $selected = $selected->merge($grp->sortByDesc('skor')->take(4));
            }
            $final = $selected->sortByDesc('skor')->take(10);

            // 4) hitung normalisasi CU (pastikan denominator sesuai numerator)
            $sumSkor = $final->sum('skor');
            $maxByField = KategoriCu::groupBy('bidang_id')
                ->select('bidang_id', DB::raw('MAX(skor) as max_skor'))
                ->pluck('max_skor', 'bidang_id');

            // Kelompokkan final per bidang untuk hitung jumlah item per bidang
            $finalByBidang = $final->groupBy(fn($i) => $i->kategori->bidang_id);
            $maxPossible = 0;
            foreach ($finalByBidang as $bidang => $items) {
                $count = $items->count();
                $maxPossible += ($maxByField[$bidang] ?? 0) * $count;
            }

            $normCu = $maxPossible > 0 ? round($sumSkor / $maxPossible, 4) : 0.0000;

            // 5) simpan ke penilaian_akhir (set PI & BI = 0 untuk sekarang)
            $bobot = BobotKriteria::pluck('bobot', 'nama_kriteria');
            $bCu = $bobot['CU'] ?? 0;
            PenilaianAkhir::updateOrCreate(
                ['peserta_id' => $submission->peserta_id],
                [
                    'skor_cu_normal' => $normCu,
                    'skor_pi_normal' => 0.0000,
                    'skor_bi_normal' => 0.0000,
                    'total_akhir'    => round($normCu * $bCu, 4),
                ]
            );

            // 6) buat record cu_selection
            CuSelection::create([
                'submission_id'   => $submission->id,
                'peserta_id'      => $submission->peserta_id,
                'level_id'        => $submission->kategori->level_id,
                'selection_round' => 1,
                'status_lolos'    => 'pending',
                'skor_cu'         => $normCu,
                'selected_at'     => now(),
            ]);
        });

        return redirect()->route('admin.verification.index')
                         ->with('success', 'Submission CU berhasil disetujui.');
    }

    public function reject(Request $request, CuSubmission $submission)
{
    $request->validate([
        'comment' => 'required|string',
    ]);

    $submission->status = CuSubmission::STATUS_REJECTED;
    $submission->comment = $request->comment;
    $submission->reviewed_at = now();
    $submission->save();

    // ✅ Redirect untuk mencegah browser mengulang GET ke URL POST
    return redirect()->route('admin.verification.index')->with('success', 'Submission berhasil ditolak.');
}


}
