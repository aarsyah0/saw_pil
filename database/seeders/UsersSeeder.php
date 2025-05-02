<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('users')->insert([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),  // Menggunakan Hash untuk menyimpan password
            'role' => 'admin',
        ]);

        DB::table('users')->insert([
            'name' => 'Mahasiswa',
            'username' => 'mahasiswa',
            'email' => 'mahasiswa@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'peserta',
        ]);

        DB::table('users')->insert([
            'name' => 'Juri',
            'username' => 'juri',
            'email' => 'juri@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'juri',
        ]);
    }
}
