<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('penilaian_akhir', function (Blueprint $table) {
            // Ubah precision sehingga dapat menyimpan hingga 10.0000 tanpa overflow
            $table->decimal('skor_cu_normal', 6, 4)->change();
            $table->decimal('skor_pi_normal', 6, 4)->change();
            $table->decimal('skor_bi_normal', 6, 4)->change();
            $table->decimal('total_akhir',    6, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('penilaian_akhir', function (Blueprint $table) {
            $table->decimal('skor_cu_normal', 5, 4)->change();
            $table->decimal('skor_pi_normal', 5, 4)->change();
            $table->decimal('skor_bi_normal', 5, 4)->change();
            $table->decimal('total_akhir',    5, 4)->change();
        });
    }
};
