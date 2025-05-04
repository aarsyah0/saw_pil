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
        'substansi_masalah',
        'substansi_solusi',
        'kualitas_pi',
        'total_score',
    ];

    // Tipe data kolom
    protected $casts = [
        'penyajian' => 'decimal:2',
        'substansi_masalah' => 'decimal:2',
        'substansi_solusi' => 'decimal:2',
        'kualitas_pi' => 'decimal:2',
        'total_score' => 'decimal:2',
    ];

    // Relasi ke jadwal
    public function schedule()
    {
        return $this->belongsTo(SchedulePiBi::class, 'schedule_id');
    }
}
