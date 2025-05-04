<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('penilaian_pi_juri', function (Blueprint $table) {
            // Hapus kolom detail lama
            $table->dropColumn([
                'substansi_masalah_fakta',
                'substansi_masalah_identifikasi',
                'substansi_masalah_penerima',
                'substansi_solusi_tujuan',
                'substansi_solusi_smart',
                'substansi_solusi_langkah',
                'substansi_solusi_kebutuhan',
                'kualitas_keunikan',
                'kualitas_orisinalitas',
                'kualitas_kelayakan',
            ]);

            // Tambah kolom agregat baru
            $table->decimal('substansi_masalah', 5, 2)
                  ->after('penyajian')
                  ->comment('Total dari semua aspek masalah (maks 20 poin)');

            $table->decimal('substansi_solusi', 5, 2)
                  ->after('substansi_masalah')
                  ->comment('Total dari semua aspek solusi (maks 35 poin)');

            $table->decimal('kualitas_pi', 5, 2)
                  ->after('substansi_solusi')
                  ->comment('Total kualitas inovasi (maks 30 poin)');

            // (Opsional) total akhir PI
            $table->decimal('total_score', 5, 2)
                  ->after('kualitas_pi')
                  ->nullable()
                  ->comment('Total skor PI (maks 100 poin)');
        });
    }

    public function down()
    {
        Schema::table('penilaian_pi_juri', function (Blueprint $table) {
            // Hapus kolom agregat
            $table->dropColumn(['substansi_masalah', 'substansi_solusi', 'kualitas_pi', 'total_score']);

            // Kembalikan kolom detail lama
            $table->decimal('substansi_masalah_fakta', 5, 2)->after('penyajian');
            $table->decimal('substansi_masalah_identifikasi', 5, 2)->after('substansi_masalah_fakta');
            $table->decimal('substansi_masalah_penerima', 5, 2)->after('substansi_masalah_identifikasi');

            $table->decimal('substansi_solusi_tujuan', 5, 2)->after('substansi_masalah_penerima');
            $table->decimal('substansi_solusi_smart', 5, 2)->after('substansi_solusi_tujuan');
            $table->decimal('substansi_solusi_langkah', 5, 2)->after('substansi_solusi_smart');
            $table->decimal('substansi_solusi_kebutuhan', 5, 2)->after('substansi_solusi_langkah');

            $table->decimal('kualitas_keunikan', 5, 2)->after('substansi_solusi_kebutuhan');
            $table->decimal('kualitas_orisinalitas', 5, 2)->after('kualitas_keunikan');
            $table->decimal('kualitas_kelayakan', 5, 2)->after('kualitas_orisinalitas');
        });
    }
};

