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

        // Bidang CU
        DB::table('bidang_cu')->insert([
            ['id'=>1,'nama'=>'Kompetisi'],
            ['id'=>2,'nama'=>'Pengakuan'],
            ['id'=>3,'nama'=>'Penghargaan'],
            ['id'=>4,'nama'=>'Karir Organisasi'],
            ['id'=>5,'nama'=>'Hasil Karya'],
            ['id'=>6,'nama'=>'Pemberdayaan atau Aksi Kemanusiaan'],
            ['id'=>7,'nama'=>'Kewirausahaan'],
        ]);

        // Level CU
        DB::table('level_cu')->insert([
            ['level'=>'A','description'=>'Internasional'],
            ['level'=>'B','description'=>'Regional'],
            ['level'=>'C','description'=>'Nasional'],
            ['level'=>'D','description'=>'Provinsi'],
            ['level'=>'E','description'=>'Kab/Kota/PT'],
        ]);

        // Bobot Kriteria - upsert to avoid duplicates
        DB::table('bobot_kriteria')->upsert([
            ['nama_kriteria'=>'CU','bobot'=>0.40],
            ['nama_kriteria'=>'PI','bobot'=>0.40],
            ['nama_kriteria'=>'BI','bobot'=>0.20],
        ], ['nama_kriteria'], ['bobot']);

        // Kategori CU
        DB::table('kategori_cu')->insert([
            // bidang 1 contoh
            ['id'=>1,'bidang_id'=>1,'wujud_cu'=>'Juara-1 Perorangan','kode'=>'1A1','level_id'=>'A','skor'=>50],
            // ... masukkan semua kategori sesuai Lampiran
        ]);

        // CU Submission
        // DB::table('cu_submission')->insert([
        //     ['id'=>1,'peserta_id'=>2,'kategori_cu_id'=>1,'file_path'=>'cu1.pdf','submitted_at'=>'2025-04-30 10:00:00','status'=>'approved','reviewed_at'=>'2025-04-30 11:00:00','comment'=>null,'skor'=>50],
        //     ['id'=>2,'peserta_id'=>2,'kategori_cu_id'=>33,'file_path'=>'cu2.pdf','submitted_at'=>'2025-04-30 10:05:00','status'=>'pending','reviewed_at'=>null,'comment'=>null,'skor'=>null],
        // ]);

        // // Penilaian Akhir
        // DB::table('penilaian_akhir')->insert([
        //     'peserta_id'     => 2,
        //     'skor_cu_normal' => 0.80,
        //     'skor_pi_normal' => 0.78,
        //     'skor_bi_normal' => 0.84,
        //     'total_akhir'    => 0.80*0.40 + 0.78*0.40 + 0.84*0.20,
        // ]);

        // // CU Selection
        // DB::table('cu_selection')->insert([
        //     'id'              => 1,
        //     'peserta_id'      => 2,
        //     'level_id'        => 'A',
        //     'selection_round' => 1,
        //     'status_lolos'    => 'lolos',
        //     'selected_at'     => '2025-04-30 11:00:00',
        // ]);

        // // Schedule PI & BI
        // DB::table('schedule_pi_bi')->insert([
        //     'id'         => 1,
        //     'peserta_id' => 2,
        //     'juri_id'    => 3,
        //     'tanggal'    => '2025-05-10',
        //     'lokasi'     => 'Lab TI Polije',
        //     'created_at' => '2025-04-30 12:00:00',
        // ]);

        // // Penilaian BI Juri
        // DB::table('penilaian_bi_juri')->insert([
        //     'id'                  => 1,
        //     'schedule_id'         => 1,
        //     'content_score'       => 80,
        //     'accuracy_score'      => 75,
        //     'fluency_score'       => 85,
        //     'pronunciation_score' => 90,
        //     'overall_perf_score'  => 88,
        //     'scored_at'           => '2025-05-10 09:00:00',
        // ]);

        // // Penilaian PI Juri
        // DB::table('penilaian_pi_juri')->insert([
        //     'id'                            => 1,
        //     'schedule_id'                   => 1,
        //     'penyajian'                     => 80,
        //     'substansi_masalah_fakta'       => 75,
        //     'substansi_masalah_identifikasi'=> 78,
        //     'substansi_masalah_penerima'    => 80,
        //     'substansi_solusi_tujuan'       => 82,
        //     'substansi_solusi_smart'        => 85,
        //     'substansi_solusi_langkah'      => 80,
        //     'substansi_solusi_kebutuhan'    => 78,
        //     'kualitas_keunikan'             => 80,
        //     'kualitas_orisinalitas'         => 82,
        //     'kualitas_kelayakan'            => 85,
        //     'scored_at'                     => '2025-05-10 10:00:00',
        // ]);

        // // Naskah PI
        // DB::table('naskah_pi')->insert([
        //     'id'             => 1,
        //     'peserta_id'     => 2,
        //     'judul'          => 'Inovasi Aplikasi X',
        //     'abstrak'        => 'Ringkasan...',
        //     'isi'            => 'Isi lengkap...',
        //     'tanggal_upload' => '2025-04-30 13:00:00',
        // ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('naskah_pi')->where('id',1)->delete();
        DB::table('penilaian_pi_juri')->where('id',1)->delete();
        DB::table('penilaian_bi_juri')->where('id',1)->delete();
        DB::table('schedule_pi_bi')->where('id',1)->delete();
        DB::table('cu_selection')->where('id',1)->delete();
        DB::table('penilaian_akhir')->where('peserta_id',2)->delete();
        DB::table('cu_submission')->whereIn('id',[1,2])->delete();
        DB::table('kategori_cu')->truncate();
        DB::table('bobot_kriteria')->truncate();
        DB::table('level_cu')->truncate();
        DB::table('bidang_cu')->truncate();
        DB::table('juri_profile')->where('user_id',3)->delete();
        DB::table('peserta_profile')->where('user_id',2)->delete();
        DB::table('admin_profile')->where('user_id',1)->delete();
        DB::table('users')->whereIn('id',[1,2,3])->delete();
    }
}
