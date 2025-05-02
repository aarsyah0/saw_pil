<?php
// database/seeders/HeroFeaturesTableSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeroFeaturesTableSeeder extends Seeder
{
    public function run()
    {
        // Ambil semua slide
        $slides = DB::table('hero_slides')->pluck('id');

        foreach ($slides as $slideId) {
            DB::table('hero_features')->insert([
                [
                    'hero_slide_id' => $slideId,
                    'icon_class'    => 'fa-solid fa-check-circle text-warning',
                    'text'          => 'Fitur unggulan slide ' . $slideId . ' - poin A',
                    'order'         => 1,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
                [
                    'hero_slide_id' => $slideId,
                    'icon_class'    => 'fa-solid fa-star text-warning',
                    'text'          => 'Fitur unggulan slide ' . $slideId . ' - poin B',
                    'order'         => 2,
                    'created_at'    => now(),
                    'updated_at'    => now(),
                ],
            ]);
        }
    }
}
