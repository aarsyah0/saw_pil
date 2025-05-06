<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AllTablesSeeder extends Seeder
{
    public function run()
    {
        // Users
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'Admin Utama',      'email' => 'admin@polije.ac.id',  'password' => Hash::make('admin'), 'role' => 'admin',   'created_at' => '2025-04-30 09:30:00', 'updated_at' => '2025-04-30 09:30:00'],
            ['id' => 2, 'name' => 'Mahasiswa Satu',    'email' => 'mhs1@polije.ac.id',   'password' => Hash::make('password'), 'role' => 'peserta', 'created_at' => '2025-04-30 09:30:00', 'updated_at' => '2025-04-30 09:30:00'],
            ['id' => 3, 'name' => 'Juri Satu',        'email' => 'juri1@univ.example',  'password' => Hash::make('password'), 'role' => 'juri',    'created_at' => '2025-04-30 09:30:00', 'updated_at' => '2025-04-30 09:30:00'],
        ]);

        // Admin Profile
        DB::table('admin_profile')->insert([
            'user_id'  => 1,
            'no_hp'    => '081234567890',
            'jabatan'  => 'Ketua Panitia',
            'instansi' => 'Politeknik Negeri Jember',
        ]);

        // Peserta Profile
        DB::table('peserta_profile')->insert([
            'user_id'           => 2,
            'nik'               => '1234567890123456',
            'tempat_lahir'      => 'Jember',
            'tanggal_lahir'     => '2002-05-10',
            'nim'               => '2021101001',
            'no_hp'             => '082345678901',
            'program_pendidikan'=> 'Sarjana',
            'program_studi'     => 'Teknik Informatika',
            'semester_ke'       => 6,
            'ipk'               => 3.75,
            'kode_pt'           => 'JBR001',
            'wilayah_lldikti'   => 'VII',
            'perguruan_tinggi'  => 'Politeknik Negeri Jember',
            'alamat_pt'         => 'Jl. Mastrip No.1, Jember',
            'telp_pt'           => '0331-123456',
            'email_pt'          => 'ti@polije.ac.id',
            'pas_foto'          => 'foto2.jpg',
            'surat_pengantar'   => 'sk2.pdf',
        ]);

        // Juri Profile
        DB::table('juri_profile')->insert([
            'user_id'         => 3,
            'no_hp'           => '083456789012',
            'instansi'        => 'Universitas Jember',
            'bidang_keahlian' => 'Teknologi Informasi',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('juri_profile')->where('user_id',3)->delete();
        DB::table('peserta_profile')->where('user_id',2)->delete();
        DB::table('admin_profile')->where('user_id',1)->delete();
        DB::table('users')->whereIn('id',[1,2,3])->delete();
    }
}
