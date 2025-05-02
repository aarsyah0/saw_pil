<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class JuriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create three new juri users and their profiles
        $juries = [
            [
                'name'              => 'Juri Satu',
                'email'             => 'juri1@example.com',
                'password'          => Hash::make('password123'),
                'no_hp'             => '081234567890',
                'instansi'          => 'Universitas Negeri A',
                'bidang_keahlian'   => 'Teknologi Informasi',
            ],
            [
                'name'              => 'Juri Dua',
                'email'             => 'juri2@example.com',
                'password'          => Hash::make('password123'),
                'no_hp'             => '081298765432',
                'instansi'          => 'Institut Teknologi B',
                'bidang_keahlian'   => 'Manajemen Agribisnis',
            ],
            [
                'name'              => 'Juri Tiga',
                'email'             => 'juri3@example.com',
                'password'          => Hash::make('password123'),
                'no_hp'             => '081212345678',
                'instansi'          => 'Sekolah Tinggi C',
                'bidang_keahlian'   => 'Produksi Pertanian',
            ],
        ];

        foreach ($juries as $j) {
            // Insert into users table
            $userId = DB::table('users')->insertGetId([
                'name'       => $j['name'],
                'email'      => $j['email'],
                'password'   => $j['password'],
                'role'       => 'juri',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            // Insert into juri_profile table
            DB::table('juri_profile')->insert([
                'user_id'         => $userId,
                'no_hp'           => $j['no_hp'],
                'instansi'        => $j['instansi'],
                'bidang_keahlian' => $j['bidang_keahlian'],
            ]);
        }
    }
}
