<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianAkhir extends Model
{
    protected $table = 'penilaian_akhir';
    protected $primaryKey = 'peserta_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'peserta_id',
        'skor_cu_normal',
        'skor_pi_normal',
        'skor_bi_normal',
        'total_akhir',
    ];

    protected $casts = [
        'skor_cu_normal' => 'decimal:4',
        'skor_pi_normal' => 'decimal:4',
        'skor_bi_normal' => 'decimal:4',
        'total_akhir'    => 'decimal:4',
    ];

    public function peserta()
    {
        return $this->belongsTo(PesertaProfile::class, 'peserta_id', 'user_id');
    }
}

