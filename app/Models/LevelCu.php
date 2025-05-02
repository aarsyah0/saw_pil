<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelCu extends Model
{
    protected $table = 'level_cu';

    // Primary key non-incrementing string
    protected $primaryKey = 'level';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'level',
        'description',
    ];

    /**
     * Relasi ke Kategori CU
     */
    public function kategoris()
    {
        return $this->hasMany(KategoriCu::class, 'level_id', 'level');
    }
}
