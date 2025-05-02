<?php
// database/seeders/RequirementsTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequirementsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('requirements')->insert([
            ['text' => 'Terdaftar di PD-Dikti, aktif D3/D4 s.d. semester VI', 'order'=>1, 'created_at'=>now(), 'updated_at'=>now()],
            ['text' => 'Usia ≤22 tahun per 1 Jan 2025', 'order'=>2, 'created_at'=>now(), 'updated_at'=>now()],
            ['text' => 'Belum pernah finalis Nasional', 'order'=>3, 'created_at'=>now(), 'updated_at'=>now()],
            ['text' => 'IPK ≥3.5', 'order'=>4, 'created_at'=>now(), 'updated_at'=>now()],
            ['text' => 'Kemampuan bahasa Inggris', 'order'=>5, 'created_at'=>now(), 'updated_at'=>now()],
            ['text' => 'Surat pengantar Jurusan (max 2 peserta)', 'order'=>6, 'created_at'=>now(), 'updated_at'=>now()],
        ]);
    }
}
