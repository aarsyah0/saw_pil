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
        'peserta_id', 'juri_id', 'tanggal', 'lokasi'
    ];
    protected $casts = [
        'tanggal' => 'date',
    ];

    /**
     * Relasi many-to-many ke model User sebagai juri
     */
    public function juris(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'schedule_pi_bi_juri',
            'schedule_id',
            'juri_id'
        )->withTimestamps();
    }

    /**
     * Relasi ke model User sebagai peserta
     */
    public function peserta(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'peserta_id',   // foreign key on this table
            'id'            // owner key on User
        );
    }
}
