<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianPiJuri extends Model
{
    // Nama tabel sesuai dump
    protected $table = 'penilaian_pi_juri';

    // Tidak pakai created_at/updated_at
    public $timestamps = false;

    // Field yang boleh di‐mass assign
    protected $fillable = [
        'schedule_id',
        'penyajian',
        'substansi_masalah_fakta',
        'substansi_masalah_identifikasi',
        'substansi_masalah_penerima',
        'substansi_solusi_tujuan',
        'substansi_solusi_smart',
        'substansi_solusi_langkah',
        'substansi_solusi_kebutuhan',
        'kualitas_keunikan',
        'kualitas_orisinalitas',
        'kualitas_kelayakan',
    ];

    // Relasi ke jadwal (opsional)
    public function schedule()
    {
        return $this->belongsTo(SchedulePiBi::class, 'schedule_id');
    }
}
