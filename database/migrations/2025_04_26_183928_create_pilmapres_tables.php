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
        // Users
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('role', ['admin', 'peserta', 'juri']);
            $table->timestamps();
        });

        // Admin Profile
        Schema::create('admin_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('no_hp', 20)->nullable();
            $table->string('jabatan', 100)->nullable();
            $table->string('instansi', 150)->nullable();
        });

        // Juri Profile
        Schema::create('juri_profile', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->primary();
            $table->string('no_hp', 20)->nullable();
            $table->string('instansi', 150)->nullable();
            $table->string('bidang_keahlian', 100)->nullable();
        });

        // Peserta Profile
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
            $table->string('pas_foto', 255);
            $table->string('surat_pengantar', 255);
        });

        // Bidang CU
        Schema::create('bidang_cu', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->string('nama', 50);
        });

        // Level CU
        Schema::create('level_cu', function (Blueprint $table) {
            $table->char('level', 1)->primary();
            $table->string('description', 50);
        });

        // Kategori CU
        Schema::create('kategori_cu', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('bidang_id')->unsigned();
            $table->string('wujud_cu', 100);
            $table->string('kode', 4);
            $table->char('level_id', 1);
            $table->decimal('skor', 5, 2);
            $table->unique(['bidang_id','wujud_cu','level_id'], 'uc_participant_subbidang');
        });

        // Bobot Kriteria
        Schema::create('bobot_kriteria', function (Blueprint $table) {
            $table->enum('nama_kriteria', ['CU','PI','BI'])->primary();
            $table->decimal('bobot', 3, 2);
        });
        DB::table('bobot_kriteria')->insert([
            ['nama_kriteria'=>'CU','bobot'=>0.40],
            ['nama_kriteria'=>'PI','bobot'=>0.40],
            ['nama_kriteria'=>'BI','bobot'=>0.20],
        ]);

        // CU Submission
        Schema::create('cu_submission', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('peserta_id');
            $table->integer('kategori_cu_id');
            $table->string('file_path', 255);
            $table->timestamp('submitted_at')->useCurrent();
            $table->enum('status',['pending','approved','rejected'])->default('pending');
            $table->timestamp('reviewed_at')->nullable();
            $table->text('comment')->nullable();
            $table->decimal('skor',5,2)->nullable();
            $table->unique(['peserta_id','kategori_cu_id'],'uq_submission');
        });

        // CU Selection
        Schema::create('cu_selection', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('peserta_id');
            $table->char('level_id',1);
            $table->tinyInteger('selection_round')->default(1);
            $table->enum('status_lolos',['lolos','gagal']);
            $table->timestamp('selected_at')->useCurrent();
            $table->unique(['peserta_id','selection_round'],'uq_selection');
        });

        // Naskah PI
        Schema::create('naskah_pi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('peserta_id');
            $table->string('judul',255)->nullable();
            $table->text('abstrak')->nullable();
            $table->longText('isi')->nullable();
            $table->timestamp('tanggal_upload')->useCurrent();
        });

        // Schedule PI & BI
        Schema::create('schedule_pi_bi', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('juri_id');
            $table->date('tanggal');
            $table->string('lokasi',150);
            $table->timestamp('created_at')->useCurrent();
        });

        // Penilaian BI Juri
        Schema::create('penilaian_bi_juri', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id');
            $table->decimal('content_score',5,2);
            $table->decimal('accuracy_score',5,2);
            $table->decimal('fluency_score',5,2);
            $table->decimal('pronunciation_score',5,2);
            $table->decimal('overall_perf_score',5,2);
            $table->timestamp('scored_at')->useCurrent();
        });

        // Penilaian PI Juri
        Schema::create('penilaian_pi_juri', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id');
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

        // Penilaian Akhir
        Schema::create('penilaian_akhir', function (Blueprint $table) {
            $table->unsignedBigInteger('peserta_id')->primary();
            $table->decimal('skor_cu_normal',5,4)->default(0);
            $table->decimal('skor_pi_normal',5,4)->default(0);
            $table->decimal('skor_bi_normal',5,4)->default(0);
            $table->decimal('total_akhir',5,4)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('penilaian_akhir');
        Schema::dropIfExists('penilaian_pi_juri');
        Schema::dropIfExists('penilaian_bi_juri');
        Schema::dropIfExists('schedule_pi_bi');
        Schema::dropIfExists('naskah_pi');
        Schema::dropIfExists('cu_selection');
        Schema::dropIfExists('cu_submission');
        Schema::dropIfExists('bobot_kriteria');
        Schema::dropIfExists('kategori_cu');
        Schema::dropIfExists('level_cu');
        Schema::dropIfExists('bidang_cu');
        Schema::dropIfExists('peserta_profile');
        Schema::dropIfExists('juri_profile');
        Schema::dropIfExists('admin_profile');
        Schema::dropIfExists('users');
    }
}
