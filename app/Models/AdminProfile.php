<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    // Tabel yang digunakan (jika nama tabel bukan plural default)
    protected $table = 'admin_profile';

    // Primary key
    protected $primaryKey = 'user_id';

    // Karena primary key bukan auto-increment integer, disable incrementing
    public $incrementing = false;
    protected $keyType = 'bigint';

    // Jika tidak memakai timestamps
    public $timestamps = false;

    // Field yang boleh di-fill
    protected $fillable = [
        'user_id',
        'no_hp',
        'jabatan',
        'instansi',
    ];
}
