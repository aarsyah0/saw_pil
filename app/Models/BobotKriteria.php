<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BobotKriteria extends Model
{
    protected $table = 'bobot_kriteria';
    protected $primaryKey = 'nama_kriteria';
    public $incrementing = false;
    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nama_kriteria',
        'bobot',
    ];

    protected $casts = [
        'bobot' => 'decimal:2',
    ];
}

