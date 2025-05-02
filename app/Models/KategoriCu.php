<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriCu extends Model
{
    protected $table = 'kategori_cu';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'bidang_id',
        'wujud_cu',
        'kode',
        'level_id',
        'skor',
    ];

    protected $casts = [
        'skor' => 'decimal:2',
    ];

    /**
     * Relasi ke tabel bidang_cu
     */
    public function bidang()
    {
        return $this->belongsTo(BidangCu::class, 'bidang_id', 'id');
    }

    /**
     * Relasi ke tabel level_cu untuk detail level
     */
    public function level()
    {
        return $this->belongsTo(LevelCu::class, 'level_id', 'level');
    }

    /**
     * Relasi ke semua submission CU untuk kategori ini
     */
    public function submissions()
    {
        return $this->hasMany(CuSubmission::class, 'kategori_cu_id', 'id');
    }
}
