<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\PesertaProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PesertaDummySeeder extends Seeder
{
    public function run(): void
{
     DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('cu_selection')->delete();
        DB::table('rekap_penilaian_tahunan')->delete();
        DB::table('peserta_profile')->delete();
        DB::table('users')->where('role', 'peserta')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        for ($year = 2019; $year <= 2024; $year++) {
            for ($i = 20; $i <= 30; $i++) {
                $id = ($year * 100) + $i;
                $name = "Peserta $id";
                $email = "peserta$id@example.com";

                $user = User::create([
                    'id' => $id,
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'peserta',
                ]);

                PesertaProfile::create([
                    'user_id' => $user->id,
                    'nik' => '3576' . str_pad($i, 8, '0', STR_PAD_LEFT),
                    'tempat_lahir' => 'Jember',
                    'tanggal_lahir' => now()->subYears(22)->format('Y-m-d'),
                    'nim' => "TI$id",
                    'no_hp' => '0812' . rand(10000000, 99999999),
                    'program_pendidikan' => 'Diploma4',
                    'program_studi' => 'Teknik Informatika',
                    'semester_ke' => rand(6, 8),
                    'ipk' => round(rand(300, 400) / 100, 2),
                    'kode_pt' => 'PNJ',
                    'wilayah_lldikti' => 'VII',
                    'perguruan_tinggi' => 'Politeknik Negeri Jember',
                    'alamat_pt' => 'Jl. Mastrip 01 Jember',
                    'telp_pt' => '0331-333222',
                    'email_pt' => 'info@polije.ac.id',
                    'pas_foto' => 'kakakaksaksjcjnajsa/akansjncajnjancjsncasj/acskancasjc.pdf',
                    'surat_pengantar' => 'kakakaksaksjcjnajsa/akansjncajnjancjsncasj/acskancasjc/surat_pengantar.pdf',
                    'jurusan' => 'Teknik Elektro',
                ]);
            }
        }
    }

}
