<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class SchedulePiBi extends Model
{
    protected $table = 'schedule_pi_bi';
    public $timestamps = false;

    protected $fillable = [
        'peserta_id',
        'juri_id',
        'tanggal',
        'lokasi',
    ];

    /**
     * Agar kolom `tanggal` di‑cast sebagai Carbon datetime (termasuk jam:menit)
     */
    protected $casts = [
        'tanggal' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Relasi many-to-many ke model User sebagai juri
     */
    public function juris(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'schedule_pi_bi_juri', // nama pivot table
            'schedule_id',         // FK di pivot menuju schedule
            'juri_id'              // FK di pivot menuju user (juri)
        )->withTimestamps();
    }

    /**
     * Relasi one-to-many inverse ke model User sebagai peserta
     */
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'peserta_id',   // FK di table schedule_pi_bi
            'id'            // PK di table users
        );
    }
}
