<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuriProfile extends Model
{
    protected $table = 'juri_profile';
    protected $primaryKey = 'user_id';
    public $incrementing = false;
    protected $keyType = 'bigint';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'no_hp',
        'instansi',
        'bidang_keahlian',
    ];
}
