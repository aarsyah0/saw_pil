<?php

namespace App\Http\Controllers\Juri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\SchedulePiBi;
use App\Models\PenilaianPiJuri;
use App\Models\PenilaianBiJuri;
use App\Models\PenilaianAkhir;
use App\Models\BobotKriteria;

class PenilaianJuriController extends Controller
{
    public function index()
    {
        $juriId = Auth::id();

        $schedules = SchedulePiBi::query()
            ->select('schedule_pi_bi.*')
            ->join('schedule_pi_bi_juri as spbj', 'schedule_pi_bi.id', '=', 'spbj.schedule_id')
            ->where('spbj.juri_id', $juriId)
            ->with('peserta')
            ->orderBy('schedule_pi_bi.tanggal')
            ->get();

        return view('juri.penilaian.penilaian', compact('schedules'));
    }

    public function createPi(SchedulePiBi $schedule)
    {
        $this->authorizeSchedule($schedule);
        return view('juri.penilaian.pi.create', compact('schedule'));
    }

    public function storePi(Request $request, SchedulePiBi $schedule)
    {
        $this->authorizeSchedule($schedule);

        // Cek apakah sudah pernah dinilai
        $penilaianAkhir = PenilaianAkhir::where('peserta_id', $schedule->peserta_id)->first();
        if ($penilaianAkhir && $penilaianAkhir->skor_pi_normal !== null) {
            return redirect()->route('juri.penilaian.index')
                ->with('error', 'Penilaian PI sudah dilakukan sebelumnya.');
        }

        $rules = [
            'penyajian'                      => 'required|numeric|between:0,100',
            'substansi_masalah_fakta'        => 'required|numeric|between:0,100',
            'substansi_masalah_identifikasi' => 'required|numeric|between:0,100',
            'substansi_masalah_penerima'     => 'required|numeric|between:0,100',
            'substansi_solusi_tujuan'        => 'required|numeric|between:0,100',
            'substansi_solusi_smart'         => 'required|numeric|between:0,100',
            'substansi_solusi_langkah'       => 'required|numeric|between:0,100',
            'substansi_solusi_kebutuhan'     => 'required|numeric|between:0,100',
            'kualitas_keunikan'              => 'required|numeric|between:0,100',
            'kualitas_orisinalitas'          => 'required|numeric|between:0,100',
            'kualitas_kelayakan'             => 'required|numeric|between:0,100',
        ];

        $data = $request->validate($rules);

        PenilaianPiJuri::create([
            'schedule_id' => $schedule->id,
            ...$data
        ]);

        $this->updatePenilaianAkhir($schedule->peserta_id);

        return redirect()->route('juri.penilaian.index')
            ->with('success', 'Penilaian PI tersimpan.');
    }

    public function createBi(SchedulePiBi $schedule)
    {
        $this->authorizeSchedule($schedule);
        return view('juri.penilaian.bi.create', compact('schedule'));
    }

    public function storeBi(Request $request, SchedulePiBi $schedule)
    {
        $this->authorizeSchedule($schedule);

        // Cek apakah sudah pernah dinilai
        $penilaianAkhir = PenilaianAkhir::where('peserta_id', $schedule->peserta_id)->first();
        if ($penilaianAkhir && $penilaianAkhir->skor_bi_normal !== null) {
            return redirect()->route('juri.penilaian.index')
                ->with('error', 'Penilaian BI sudah dilakukan sebelumnya.');
        }

        $rules = [
            'content_score'       => 'required|numeric|between:0,100',
            'accuracy_score'      => 'required|numeric|between:0,100',
            'fluency_score'       => 'required|numeric|between:0,100',
            'pronunciation_score' => 'required|numeric|between:0,100',
            'overall_perf_score'  => 'required|numeric|between:0,100',
        ];

        $data = $request->validate($rules);

        PenilaianBiJuri::create([
            'schedule_id' => $schedule->id,
            ...$data
        ]);

        $this->updatePenilaianAkhir($schedule->peserta_id);

        return redirect()->route('juri.penilaian.index')
            ->with('success', 'Penilaian BI tersimpan.');
    }

    private function updatePenilaianAkhir(int $pesertaId): void
    {
        $pi = DB::table('avg_penilaian_pi')
            ->where('peserta_id', $pesertaId)
            ->value('avg_pi_normal') ?? 0;

        $bi = DB::table('avg_penilaian_bi')
            ->where('peserta_id', $pesertaId)
            ->value('avg_bi_normal') ?? 0;

        $cu = DB::table('penilaian_akhir')
            ->where('peserta_id', $pesertaId)
            ->value('skor_cu_normal') ?? 0;

        $bobot = BobotKriteria::pluck('bobot', 'nama_kriteria');
        $wCU = $bobot['CU'] ?? 0;
        $wPI = $bobot['PI'] ?? 0;
        $wBI = $bobot['BI'] ?? 0;

        $total = $cu * $wCU + $pi * $wPI + $bi * $wBI;

        PenilaianAkhir::updateOrCreate(
            ['peserta_id' => $pesertaId],
            [
                'skor_cu_normal' => $cu,
                'skor_pi_normal' => $pi,
                'skor_bi_normal' => $bi,
                'total_akhir'    => $total,
            ]
        );
    }

    private function authorizeSchedule(SchedulePiBi $schedule)
    {
        $exists = DB::table('schedule_pi_bi_juri')
            ->where('schedule_id', $schedule->id)
            ->where('juri_id', Auth::id())
            ->exists();

        abort_unless($exists, 403);
    }
}
