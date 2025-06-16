<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RekapPenilaianTahunan;
use Illuminate\Support\Facades\DB;

class RekapitulasiTahunanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rekap_penilaian_tahunan')->truncate();

        $pesertaList = DB::table('peserta_profile')->pluck('user_id');

        $grouped = $pesertaList->groupBy(fn($id) => substr($id, 0, 4));

        foreach ($grouped as $tahun => $ids) {
            $selectedIds = collect($ids)->take(10); // ambil 10 peserta per tahun

            foreach ($selectedIds as $pid) {
                $skorCU = round(mt_rand(10, 100) / 100, 4);
                $skorPI = round(mt_rand(0, 100) / 100, 4);
                $skorBI = round(mt_rand(0, 100) / 100, 4);
                $total = round($skorCU * 0.4 + $skorPI * 0.3 + $skorBI * 0.3, 4);

                RekapPenilaianTahunan::create([
                    'peserta_id'       => $pid,
                    'tahun'            => $tahun,
                    'skor_cu_normal'   => $skorCU,
                    'skor_pi_normal'   => $skorPI,
                    'skor_bi_normal'   => $skorBI,
                    'total_akhir'      => $total,
                    'status_cu'        => $total >= 0.5 ? 'lolos' : 'gagal',
                    'selection_round'  => 1,
                    'created_at'       => now(),
                    'updated_at'       => now(),
                ]);
            }
        }
    }
}
