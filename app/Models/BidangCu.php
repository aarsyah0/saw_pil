<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidangCu extends Model
{
    // Nama tabel jika tidak mengikuti konvensi Laravel (opsional jika tabel bernama 'bidang_cu')
    protected $table = 'bidang_cu';

    // Nonaktifkan timestamps (created_at, updated_at)
    public $timestamps = false;

    // Kolom yang boleh diisi mass-assignment
    protected $fillable = [
        'nama',
    ];

    /**
     * Relasi ke Kategori CU:
     * Satu Bidang memiliki banyak KategoriCu.
     */
    public function kategoris()
    {
        return $this->hasMany(KategoriCu::class, 'bidang_id');
    }
}
