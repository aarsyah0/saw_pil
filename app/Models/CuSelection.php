<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CuSelection extends Model
{
    protected $table = 'cu_selection';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'peserta_id',
        'level_id',
        'selection_round',
        'status_lolos',
        'skor_cu',        // ← pastikan ada
        'selected_at',
        'submission_id',  // jika Anda menambahkan ini
      ];
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(PesertaProfile::class, 'peserta_id', 'user_id');
    }

    /**
     * Relasi ke tabel level_cu untuk mendapatkan deskripsi level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(LevelCu::class, 'level_id', 'level');
    }

    public function penilaianAkhir(): BelongsTo
    {
        return $this->belongsTo(PenilaianAkhir::class, 'peserta_id', 'peserta_id');
    }

}
