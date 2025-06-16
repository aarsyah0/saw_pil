<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_penilaian_tahunan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->year('tahun');

            $table->decimal('skor_cu_normal', 6, 4)->default(0);
            $table->decimal('skor_pi_normal', 6, 4)->default(0);
            $table->decimal('skor_bi_normal', 6, 4)->default(0);
            $table->decimal('total_akhir', 6, 4)->default(0);

            $table->enum('status_cu', ['lolos', 'gagal', 'pending'])->default('pending');
            $table->unsignedTinyInteger('selection_round')->default(0);

            $table->timestamps();

            $table->unique(['peserta_id', 'tahun']);
            $table->foreign('peserta_id')->references('user_id')->on('peserta_profile')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_penilaian_tahunan');
    }
};
