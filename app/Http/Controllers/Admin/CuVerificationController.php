<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CuSubmission;
use Illuminate\Http\Request;
use App\Models\PesertaProfile;
use App\Models\PenilaianAkhir;
use App\Models\CuSelection;
use App\Models\KategoriCu;
use Illuminate\Support\Facades\DB;

class CuVerificationController extends Controller
{
    public function index()
    {
        $submissions = CuSubmission::with(['peserta.user', 'kategori'])
            ->where('status', CuSubmission::STATUS_PENDING)
            ->whereHas('kategori', fn($q) =>
                $q->whereColumn('cu_submission.skor', '>=', 'kategori_cu.skor')
            )
            ->get();

        return view('admin.verifikasiberkas', compact('submissions'));
    }

    public function approve(CuSubmission $submission)
{
    DB::transaction(function () use ($submission) {
        // 1) Tandai sebagai disetujui
        $submission->update([
            'status'      => CuSubmission::STATUS_APPROVED,
            'reviewed_at' => now(),
        ]);

        // 2) Ambil semua CU approved peserta ini
        $approvedCUs = CuSubmission::with('kategori')
            ->where('peserta_id', $submission->peserta_id)
            ->where('status', CuSubmission::STATUS_APPROVED)
            ->get();

        // 3) Kelompokkan berdasarkan bidang
        $groupedByBidang = $approvedCUs->groupBy(function ($item) {
            return $item->kategori->bidang_id; // pastikan relasi 'kategori' memuat 'bidang_id'
        });

        $selectedCUs = collect();

        // 4) Ambil maksimal 4 CU skor tertinggi per bidang
        foreach ($groupedByBidang as $cuGroup) {
            $topPerBidang = $cuGroup->sortByDesc('skor')->take(4);
            $selectedCUs = $selectedCUs->merge($topPerBidang);
        }

        // 5) Dari semua yang terkumpul, ambil maksimal 10 CU terbaik
        $finalSelectedCUs = $selectedCUs->sortByDesc('skor')->take(10);

        // 6) Hitung total skor dari CU yang terpilih
        $totalSkorCU = $finalSelectedCUs->sum('skor');

        // 7) Hitung total skor maksimal sesuai struktur tabel kategori_cu (sum skor maksimal dari 10 CU)
        $maxSkorPerBidang = KategoriCu::groupBy('bidang_id')
            ->select('bidang_id', DB::raw('MAX(skor) as max_skor'))
            ->get()
            ->pluck('max_skor', 'bidang_id');

        // Hitung skor maksimal yang memungkinkan = (max 4 CU per bidang) * skor maksimal per bidang
        $maxSkorCU = 0;
        foreach ($maxSkorPerBidang as $bidangId => $maxSkor) {
            $countInThisBidang = $groupedByBidang->has($bidangId) ? min(4, $groupedByBidang[$bidangId]->count()) : 0;
            $maxSkorCU += $maxSkor * $countInThisBidang;
        }

        // Normalisasi skor (pastikan tidak nol pembaginya)
        $norm = $maxSkorCU > 0 ? $totalSkorCU / $maxSkorCU : 0;

        // 8) Simpan ke penilaian_akhir
        PenilaianAkhir::updateOrCreate(
            ['peserta_id' => $submission->peserta_id],
            ['skor_cu_normal' => $norm]
        );

        // 9) Tambahkan data ke cu_selection (status_lolos tetap pending)
        CuSelection::create([
            'submission_id'    => $submission->id,
            'peserta_id'       => $submission->peserta_id,
            'level_id'         => $submission->kategori->level_id,
            'selection_round'  => 1,
            'status_lolos'     => 'pending',
            'skor_cu'          => $norm,
            'selected_at'      => now(),
        ]);
    });

    return redirect()
        ->route('admin.verification.index')
        ->with('success', 'Submission berhasil disetujui dan skor CU diperbarui.');
}







    public function reject(CuSubmission $submission, Request $request)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $submission->update([
            'status'      => CuSubmission::STATUS_REJECTED,
            'reviewed_at' => now(),
            'comment'     => $request->comment,
        ]);

        return redirect()
            ->route('admin.verification.index')
            ->with('success', 'Submission berhasil ditolak.');
    }
}
