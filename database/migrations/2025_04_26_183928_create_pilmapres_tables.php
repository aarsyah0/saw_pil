<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Base tables without FKs
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password');
            $table->enum('role', ['admin','peserta','juri']);
            $table->timestamps();
        });

        Schema::create('level_cu', function (Blueprint $table) {
            $table->char('level', 1)->primary();
            $table->string('description', 50);
        });

        Schema::create('bidang_cu', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nama', 50);
        });

        Schema::create('bobot_kriteria', function (Blueprint $table) {
            $table->enum('nama_kriteria', ['CU','PI','BI'])->primary();
            $table->decimal('bobot', 3, 2);
        });

        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('date_from');
            $table->date('date_to')->nullable();
            $table->string('activity');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image_path');
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('requirements', function (Blueprint $table) {
            $table->id();
            $table->string('text');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        Schema::create('purposes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('icon_path')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Profiles (depends on users)
        Schema::create('admin_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('instansi', 150)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('juri_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('no_hp', 20)->nullable();
            $table->string('instansi', 150)->nullable();
            $table->string('bidang_keahlian', 100)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('peserta_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('nik', 20);
            $table->string('tempat_lahir', 50);
            $table->date('tanggal_lahir');
            $table->string('nim', 20);
            $table->string('no_hp', 20);
            $table->enum('program_pendidikan', ['Diploma','Sarjana']);
            $table->string('program_studi', 100);
            $table->tinyInteger('semester_ke');
            $table->decimal('ipk', 3, 2);
            $table->string('kode_pt', 10);
            $table->string('wilayah_lldikti', 50);
            $table->string('perguruan_tinggi', 150);
            $table->text('alamat_pt');
            $table->string('telp_pt', 20);
            $table->string('email_pt', 100);
            $table->string('pas_foto');
            $table->string('surat_pengantar');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // CU and related
        Schema::create('kategori_cu', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('bidang_id');
            $table->string('wujud_cu', 100);
            $table->string('kode', 4);
            $table->char('level_id', 1);
            $table->decimal('skor', 5, 2);
            $table->unique(['bidang_id','wujud_cu','level_id']);
            $table->foreign('bidang_id')->references('id')->on('bidang_cu')->onDelete('cascade');
            $table->foreign('level_id')->references('level')->on('level_cu')->onDelete('cascade');
        });

        Schema::create('cu_submission', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('kategori_cu_id');
            $table->string('file_path');
            $table->timestamp('submitted_at')->useCurrent();
            $table->enum('status', ['pending','approved','rejected'])->default('pending');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('skor', 5, 2)->nullable();
            $table->foreign('peserta_id')->references('user_id')->on('peserta_profile')->onDelete('cascade');
            $table->foreign('kategori_cu_id')->references('id')->on('kategori_cu')->onDelete('cascade');
        });

        Schema::create('cu_selection', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('submission_id')->unique()->nullable();
            $table->unsignedBigInteger('peserta_id');
            $table->char('level_id', 1);
            $table->tinyInteger('selection_round')->default(1);
            $table->enum('status_lolos', ['lolos','gagal','pending']);
            $table->boolean('pending')->default(false);
            $table->decimal('skor_cu', 5, 4)->default(0);
            $table->timestamp('selected_at')->useCurrent();
            $table->foreign('submission_id')->references('id')->on('cu_submission')->onDelete('cascade');
            $table->foreign('peserta_id')->references('user_id')->on('peserta_profile')->onDelete('cascade');
            $table->foreign('level_id')->references('level')->on('level_cu')->onDelete('cascade');
        });

        // PI/BI schedules and scoring
        Schema::create('schedule_pi_bi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('juri_id');
            $table->date('tanggal');
            $table->string('lokasi', 150);
            $table->timestamp('created_at')->useCurrent();
            $table->foreign('peserta_id')->references('user_id')->on('peserta_profile')->onDelete('cascade');
            $table->foreign('juri_id')->references('user_id')->on('juri_profile')->onDelete('cascade');
        });

        Schema::create('schedule_pi_bi_juri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->unsignedBigInteger('juri_id');
            $table->timestamps();
            $table->unique(['schedule_id','juri_id']);
            $table->foreign('schedule_id')->references('id')->on('schedule_pi_bi')->onDelete('cascade');
            $table->foreign('juri_id')->references('user_id')->on('juri_profile')->onDelete('cascade');
        });

        Schema::create('penilaian_bi_juri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->decimal('content_score',5,2);
            $table->decimal('accuracy_score',5,2);
            $table->decimal('fluency_score',5,2);
            $table->decimal('pronunciation_score',5,2);
            $table->decimal('overall_perf_score',5,2);
            $table->decimal('total_score',5,2)->nullable()->comment('Total skor BI (maks 100 poin)');
            $table->timestamp('scored_at')->useCurrent();
            $table->foreign('schedule_id')->references('id')->on('schedule_pi_bi')->onDelete('cascade');
        });

        Schema::create('penilaian_pi_juri', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('schedule_id');
            $table->decimal('penyajian',5,2);
            $table->decimal('substansi_masalah',5,2)->comment('Total dari semua aspek masalah (maks 20 poin)');
            $table->decimal('substansi_solusi',5,2)->comment('Total dari semua aspek solusi (maks 35 poin)');
            $table->decimal('kualitas_pi',5,2)->comment('Total kualitas inovasi (maks 30 poin)');
            $table->decimal('total_score',5,2)->nullable()->comment('Total skor PI (maks 100 poin)');
            $table->timestamp('scored_at')->useCurrent();
            $table->foreign('schedule_id')->references('id')->on('schedule_pi_bi')->onDelete('cascade');
        });

        Schema::create('naskah_pi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->string('judul')->nullable();
            $table->text('abstrak')->nullable();
            $table->longText('isi')->nullable();
            $table->timestamp('tanggal_upload')->useCurrent();
            $table->foreign('peserta_id')->references('user_id')->on('peserta_profile')->onDelete('cascade');
        });

        Schema::create('penilaian_akhir', function (Blueprint $table) {
            $table->unsignedBigInteger('peserta_id')->primary();
            $table->decimal('skor_cu_normal', 6, 4);
            $table->decimal('skor_pi_normal', 6, 4);
            $table->decimal('skor_bi_normal', 6, 4);
            $table->decimal('total_akhir', 6, 4);
            $table->foreign('peserta_id')->references('user_id')->on('peserta_profile')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('penilaian_akhir');
        Schema::dropIfExists('naskah_pi');
        Schema::dropIfExists('penilaian_pi_juri');
        Schema::dropIfExists('penilaian_bi_juri');
        Schema::dropIfExists('schedule_pi_bi_juri');
        Schema::dropIfExists('schedule_pi_bi');
        Schema::dropIfExists('cu_selection');
        Schema::dropIfExists('cu_submission');
        Schema::dropIfExists('kategori_cu');
        Schema::dropIfExists('peserta_profile');
        Schema::dropIfExists('juri_profile');
        Schema::dropIfExists('admin_profile');
        Schema::dropIfExists('purposes');
        Schema::dropIfExists('requirements');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('bobot_kriteria');
        Schema::dropIfExists('bidang_cu');
        Schema::dropIfExists('level_cu');
        Schema::dropIfExists('users');
    }
};
