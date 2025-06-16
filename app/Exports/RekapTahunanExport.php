<?php

namespace App\Exports;

use App\Models\RekapPenilaianTahunan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RekapTahunanExport implements FromView
{
    protected $tahun;

    public function __construct($tahun)
    {
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('exports.rekap_tahunan', [
            'rekap' => RekapPenilaianTahunan::with('peserta.user')
                        ->where('tahun', $this->tahun)
                        ->orderByDesc('total_akhir')
                        ->get(),
            'tahun' => $this->tahun,
        ]);
    }
}

