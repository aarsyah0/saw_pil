<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class CreatePilmapresTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // admin_profile
        Schema::create('admin_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('instansi', 150)->nullable();
        });

        // bidang_cu
        Schema::create('bidang_cu', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nama', 50);
        });

        // bobot_kriteria
        Schema::create('bobot_kriteria', function (Blueprint $table) {
            $table->enum('nama_kriteria', ['CU','PI','BI'])->primary();
            $table->decimal('bobot', 3, 2);
        });

        // cu_selection
        Schema::create('cu_selection', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->unsignedBigInteger('submission_id')->unique()->nullable();
            $table->unsignedBigInteger('peserta_id');
            $table->char('level_id',1);
            $table->tinyInteger('selection_round')->default(1);
            $table->enum('status_lolos',['lolos','gagal','pending']);
            $table->boolean('pending')->default(false);
            $table->decimal('skor_cu',5,4)->default(0.0000);
            $table->timestamp('selected_at')->useCurrent();
        });

        // cu_submission
        Schema::create('cu_submission', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedBigInteger('peserta_id');
            $table->integer('kategori_cu_id');
            $table->string('file_path');
            $table->timestamp('submitted_at')->useCurrent();
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('skor',5,2)->nullable();
        });

        // failed_jobs
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->string('uuid');
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // hero_slides
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('image_path');
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // hero_features
        Schema::create('hero_features', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->unsignedBigInteger('hero_slide_id');
            $table->string('icon_class');
            $table->string('text');
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->foreign('hero_slide_id')->references('id')->on('hero_slides')->onDelete('cascade');
        });

        // juri_profile
        Schema::create('juri_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('no_hp', 20)->nullable();
            $table->string('instansi', 150)->nullable();
            $table->string('bidang_keahlian', 100)->nullable();
        });

        // kategori_cu
        Schema::create('kategori_cu', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->tinyInteger('bidang_id')->unsigned();
            $table->string('wujud_cu',100);
            $table->string('kode',4);
            $table->char('level_id',1);
            $table->decimal('skor',5,2);
        });

        // level_cu
        Schema::create('level_cu', function (Blueprint $table) {
            $table->char('level',1)->primary();
            $table->string('description',50);
        });

        // migrations
        Schema::create('migrations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('migration');
            $table->integer('batch');
        });

        // naskah_pi
        Schema::create('naskah_pi', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedBigInteger('peserta_id');
            $table->string('judul')->nullable();
            $table->text('abstrak')->nullable();
            $table->longText('isi')->nullable();
            $table->timestamp('tanggal_upload')->useCurrent();
        });

        // password_resets
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // peserta_profile
        Schema::create('peserta_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('nik',20);
            $table->string('tempat_lahir',50);
            $table->date('tanggal_lahir');
            $table->string('nim',20);
            $table->string('no_hp',20);
            $table->enum('program_pendidikan',['Diploma','Sarjana']);
            $table->string('program_studi',100);
            $table->tinyInteger('semester_ke');
            $table->decimal('ipk',3,2);
            $table->string('kode_pt',10);
            $table->string('wilayah_lldikti',50);
            $table->string('perguruan_tinggi',150);
            $table->text('alamat_pt');
            $table->string('telp_pt',20);
            $table->string('email_pt',100);
            $table->string('pas_foto');
            $table->string('surat_pengantar');
        });

        // purposes
        Schema::create('purposes', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->string('title');
            $table->text('description');
            $table->string('icon_path')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // requirements
        Schema::create('requirements', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->string('text');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // schedules
        Schema::create('schedules', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->date('date_from');
            $table->date('date_to')->nullable();
            $table->string('activity');
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // schedule_pi_bi
        Schema::create('schedule_pi_bi', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('juri_id');
            $table->date('tanggal');
            $table->string('lokasi',150);
            $table->timestamp('created_at')->useCurrent();
        });

        // schedule_pi_bi_juri
        Schema::create('schedule_pi_bi_juri', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->unsignedInteger('schedule_id');
            $table->unsignedBigInteger('juri_id');
            $table->timestamps();
            $table->unique(['schedule_id','juri_id']);
            $table->foreign('schedule_id')->references('id')->on('schedule_pi_bi')->onDelete('cascade');
            $table->foreign('juri_id')->references('user_id')->on('juri_profile')->onDelete('cascade');
        });

        // sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->string('ip_address',45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // users
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedBigIncrements('id');
            $table->string('name',100);
            $table->string('email',100)->unique();
            $table->string('password');
            $table->enum('role',['admin','peserta','juri']);
            $table->timestamps();
        });

        // penilaian_akhir
        Schema::create('penilaian_akhir', function (Blueprint $table) {
            $table->unsignedBigInteger('peserta_id')->primary();
            $table->decimal('skor_cu_normal',5,4)->default(0.0000);
            $table->decimal('skor_pi_normal',5,4)->default(0.0000);
            $table->decimal('skor_bi_normal',5,4)->default(0.0000);
            $table->decimal('total_akhir',5,4)->default(0.0000);
        });

        // penilaian_bi_juri
        Schema::create('penilaian_bi_juri', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('schedule_id');
            $table->decimal('content_score',5,2);
            $table->decimal('accuracy_score',5,2);
            $table->decimal('fluency_score',5,2);
            $table->decimal('pronunciation_score',5,2);
            $table->decimal('overall_perf_score',5,2);
            $table->timestamp('scored_at')->useCurrent();
        });

        // penilaian_pi_juri
        Schema::create('penilaian_pi_juri', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('schedule_id');
            $table->decimal('penyajian',5,2);
            $table->decimal('substansi_masalah_fakta',5,2);
            $table->decimal('substansi_masalah_identifikasi',5,2);
            $table->decimal('substansi_masalah_penerima',5,2);
            $table->decimal('substansi_solusi_tujuan',5,2);
            $table->decimal('substansi_solusi_smart',5,2);
            $table->decimal('substansi_solusi_langkah',5,2);
            $table->decimal('substansi_solusi_kebutuhan',5,2);
            $table->decimal('kualitas_keunikan',5,2);
            $table->decimal('kualitas_orisinalitas',5,2);
            $table->decimal('kualitas_kelayakan',5,2);
            $table->timestamp('scored_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian_pi_juri');
        Schema::dropIfExists('penilaian_bi_juri');
        Schema::dropIfExists('penilaian_akhir');
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('schedule_pi_bi_juri');
        Schema::dropIfExists('schedule_pi_bi');
        Schema::dropIfExists('schedules');
        Schema::dropIfExists('requirements');
        Schema::dropIfExists('purposes');
        Schema::dropIfExists('peserta_profile');
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('naskah_pi');
        Schema::dropIfExists('migrations');
        Schema::dropIfExists('level_cu');
        Schema::dropIfExists('kategori_cu');
        Schema::dropIfExists('juri_profile');
        Schema::dropIfExists('hero_features');
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('cu_submission');
        Schema::dropIfExists('cu_selection');
        Schema::dropIfExists('bobot_kriteria');
        Schema::dropIfExists('bidang_cu');
        Schema::dropIfExists('admin_profile');
    }
}
