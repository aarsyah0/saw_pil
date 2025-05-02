<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SchedulePiBi extends Model
{
    protected $table = 'schedule_pi_bi';
    public $timestamps = false;
    protected $fillable = [
      'peserta_id','juri_id','tanggal','lokasi'
    ];
    protected $casts = ['tanggal'=>'date'];

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(\App\Models\PesertaProfile::class,
                               'peserta_id','user_id');
    }

    public function juris(): BelongsToMany
    {
        return $this->belongsToMany(
            \App\Models\User::class,
            'schedule_pi_bi_juri',
            'schedule_id',
            'juri_id'
        )->withTimestamps();
    }
}
