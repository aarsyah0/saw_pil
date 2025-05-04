<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesertaProfile extends Model
{
    protected $table = 'peserta_profile';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'nim',
        'no_hp',
        'program_pendidikan',
        'program_studi',
        'semester_ke',
        'ipk',
        'kode_pt',
        'wilayah_lldikti',
        'perguruan_tinggi',
        'alamat_pt',
        'telp_pt',
        'email_pt',
        'pas_foto',
        'surat_pengantar',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'ipk'           => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Akses nama langsung via $peserta->name
    public function getNameAttribute(): ?string
    {
        return $this->user?->name;
    }
    public function cuSelection()
    {
        return $this->hasMany(
            \App\Models\CuSelection::class,
            'peserta_id',    // FK di cu_selection
            'user_id'        // PK di peserta_profile
        );
    }

}
