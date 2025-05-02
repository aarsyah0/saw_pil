<?php
// database/seeders/PurposesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurposesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('purposes')->insert([
            [
                'title'       => 'Mendorong mahasiswa berinovasi',
                'description' => 'Memberi ruang bagi ide dan kreativitas mahasiswa.',
                'icon_path'   => 'icons/innovation.png',
                'order'       => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Asah keterampilan kepemimpinan',
                'description' => 'Mengembangkan jiwa pemimpin melalui kompetisi.',
                'icon_path'   => 'icons/leadership.png',
                'order'       => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Apresiasi prestasi unggulan',
                'description' => 'Memberikan penghargaan bagi prestasi terbaik.',
                'icon_path'   => 'icons/award.png',
                'order'       => 3,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
