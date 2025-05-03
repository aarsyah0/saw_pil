<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianBiJuri extends Model
{
    // Nama tabel sesuai dump
    protected $table = 'penilaian_bi_juri';

    // Tidak pakai created_at/updated_at
    public $timestamps = false;

    // Field yang boleh di‐mass assign
    protected $fillable = [
        'schedule_id',
        'content_score',
        'accuracy_score',
        'fluency_score',
        'pronunciation_score',
        'overall_perf_score',
    ];

    // Relasi ke jadwal (opsional)
    public function schedule()
    {
        return $this->belongsTo(SchedulePiBi::class, 'schedule_id');
    }
}
