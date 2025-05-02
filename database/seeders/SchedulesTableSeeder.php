<?php
// database/seeders/SchedulesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SchedulesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('schedules')->insert([
            [
                'date_from'  => '2025-03-04',
                'date_to'    => '2025-03-10',
                'activity'   => 'Pendaftaran & seleksi jurusan',
                'order'      => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_from'  => '2025-03-12',
                'date_to'    => '2025-03-14',
                'activity'   => 'Seleksi administrasi internal',
                'order'      => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_from'  => '2025-03-15',
                'date_to'    => '2025-03-15',
                'activity'   => 'Pengumuman 10 besar Polije',
                'order'      => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_from'  => '2025-03-21',
                'date_to'    => '2025-03-23',
                'activity'   => 'Seleksi tingkat Polije',
                'order'      => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_from'  => '2025-04-09',
                'date_to'    => '2025-04-30',
                'activity'   => 'BIMTEK/Pelatihan juara Polije',
                'order'      => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_from'  => '2025-05-02',
                'date_to'    => '2025-05-12',
                'activity'   => 'Seleksi Wilayah',
                'order'      => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'date_from'  => '2025-05-01',
                'date_to'    => '2025-07-31',
                'activity'   => 'PILMAPRES Nasional',
                'order'      => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
