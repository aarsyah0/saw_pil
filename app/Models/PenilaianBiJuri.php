<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianBiJuri extends Model
{
    protected $table = 'penilaian_bi_juri';
    public $timestamps = false;

    protected $fillable = [
        'schedule_id',
        'content_score',
        'accuracy_score',
        'fluency_score',
        'pronunciation_score',
        'overall_perf_score',
        'total_score',        // ← tambahkan ini
    ];

    protected $casts = [
        'content_score'       => 'decimal:2',
        'accuracy_score'      => 'decimal:2',
        'fluency_score'       => 'decimal:2',
        'pronunciation_score' => 'decimal:2',
        'overall_perf_score'  => 'decimal:2',
        'total_score'         => 'decimal:2',  // ← dan ini
    ];

    public function schedule()
    {
        return $this->belongsTo(SchedulePiBi::class, 'schedule_id');
    }
}
