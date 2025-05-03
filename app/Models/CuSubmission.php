<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuSubmission extends Model
{
    protected $table = 'cu_submission';
    protected $primaryKey = 'id';
    public $timestamps = false;

    const STATUS_PENDING  = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    protected $fillable = [
        'peserta_id',
        'kategori_cu_id',
        'file_path',
        'status',
        'reviewed_at',
        'comment',
        'skor',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'skor'        => 'decimal:2',
    ];

    public function peserta()
    {
        return $this->belongsTo(PesertaProfile::class, 'peserta_id', 'user_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriCu::class, 'kategori_cu_id', 'id');
    }
    public function kategoriCu()
{
    return $this->belongsTo(KategoriCu::class, 'kategori_cu_id', 'id');
}
}

