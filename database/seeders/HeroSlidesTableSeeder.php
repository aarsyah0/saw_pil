<?php
// database/seeders/HeroSlidesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroSlidesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('hero_slides')->insert([
            [
                'title'       => 'Selamat Datang di PILMAPRES POLIJE',
                'subtitle'    => 'Tunjukkan Prestasimu!',
                'image_path'  => 'hero/hero.png',
                'button_text' => 'Daftar Sekarang',
                'button_url'  => '/register',
                'order'       => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'title'       => 'Kembangkan Inovasi',
                'subtitle'    => 'Ajang Mahasiswa Berprestasi',
                'image_path'  => 'hero/gedkes.jpg',
                'button_text' => 'Lihat Jadwal',
                'button_url'  => '#jadwal',
                'order'       => 2,
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ]);
    }
}
