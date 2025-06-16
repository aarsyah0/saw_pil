<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapPenilaianTahunan extends Model
{
    use HasFactory;

    protected $table = 'rekap_penilaian_tahunan';

    protected $fillable = [
        'peserta_id',
        'tahun',
        'skor_cu_normal',
        'skor_pi_normal',
        'skor_bi_normal',
        'total_akhir',
        'status_cu',
        'selection_round',
    ];

    public function peserta()
    {
        return $this->belongsTo(PesertaProfile::class, 'peserta_id', 'user_id');
    }

}
