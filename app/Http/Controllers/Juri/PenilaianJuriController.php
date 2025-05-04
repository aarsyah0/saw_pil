<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SchedulePiBi;
use App\Models\PenilaianPiJuri;
use App\Models\PenilaianBiJuri;
use App\Models\PenilaianAkhir;
use App\Models\BobotKriteria;
use Illuminate\Http\Request;

class PenilaianJuriController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $juriId = Auth::id();
        $schedules = SchedulePiBi::with('peserta')
            ->join('schedule_pi_bi_juri as spbj', 'schedule_pi_bi.id', '=', 'spbj.schedule_id')
            ->where('spbj.juri_id', $juriId)
            ->select('schedule_pi_bi.*')
            ->get();
        return view('juri.penilaian.penilaian', compact('schedules'));
    }

    public function storePi(Request $request, SchedulePiBi $schedule)
    {
        // ... validasi seperti sebelumnya ...
        $data = $request->validate([
            'penyajian' => 'required|numeric|between:0,15',
            'substansi_masalah' => 'required|numeric|between:0,20',
            'substansi_solusi' => 'required|numeric|between:0,35',
            'kualitas_pi' => 'required|numeric|between:0,30',
        ]);
        $data['schedule_id'] = $schedule->id;
        $data['total_score'] = array_sum([$data['penyajian'], $data['substansi_masalah'], $data['substansi_solusi'], $data['kualitas_pi']]);
        PenilaianPiJuri::create($data);
        $this->updatePenilaianAkhir($schedule->peserta_id);
        return back()->with('success', 'Penilaian PI disimpan.');
    }

    public function storeBi(Request $request, SchedulePiBi $schedule)
    {
        // ... validasi seperti sebelumnya ...
        $data = $request->validate([
            'content_score' => 'required|numeric|between:0,25',
            'accuracy_score' => 'required|numeric|between:0,25',
            'fluency_score' => 'required|numeric|between:0,20',
            'pronunciation_score' => 'required|numeric|between:0,20',
            'overall_perf_score' => 'required|numeric|between:0,10',
        ]);
        $data['schedule_id'] = $schedule->id;
        $data['total_score'] = array_sum([$data['content_score'], $data['accuracy_score'], $data['fluency_score'], $data['pronunciation_score'], $data['overall_perf_score']]);
        PenilaianBiJuri::create($data);
        $this->updatePenilaianAkhir($schedule->peserta_id);
        return back()->with('success', 'Penilaian BI disimpan.');
    }

    private function updatePenilaianAkhir(int $pesertaId): void
    {
        // Ambil semua schedule_id peserta
        $scheduleIds = SchedulePiBi::where('peserta_id', $pesertaId)->pluck('id');

        // Hitung PI & BI normalisasi rata-rata
        $piNormal = PenilaianPiJuri::whereIn('schedule_id', $scheduleIds)
            ->get()->avg(fn($row) => $row->total_score / 100) ?: 0.0;
        $biNormal = PenilaianBiJuri::whereIn('schedule_id', $scheduleIds)
            ->get()->avg(fn($row) => $row->total_score / 100) ?: 0.0;

        // Ambil CU yang tersimpan
        $skorCu = PenilaianAkhir::where('peserta_id', $pesertaId)
            ->value('skor_cu_normal') ?: 0.0;

        // Hitung total terpadu tanpa mereset CU
        $bobot = BobotKriteria::pluck('bobot','nama_kriteria')->toArray();
        $total = round(
            $skorCu * ($bobot['CU'] ?? 0)
          + $piNormal * ($bobot['PI'] ?? 0)
          + $biNormal * ($bobot['BI'] ?? 0)
        , 4);

        // Simpan hasil tanpa menimpa CU
        $pa = PenilaianAkhir::firstOrNew(['peserta_id' => $pesertaId]);
        $pa->skor_cu_normal = $skorCu;
        $pa->skor_pi_normal = $piNormal;
        $pa->skor_bi_normal = $biNormal;
        $pa->total_akhir    = $total;
        $pa->save();
    }
}
