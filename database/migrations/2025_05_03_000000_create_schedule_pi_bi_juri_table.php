<?php
// database/migrations/2025_05_03_000000_create_schedule_pi_bi_juri_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulePiBiJuriTable extends Migration
{
    public function up()
    {
        Schema::create('schedule_pi_bi_juri', function (Blueprint $table) {
            $table->id();

            // MATCH schedule_pi_bi.id which is INT(11) signed
            $table->unsignedInteger('schedule_id');
            $table->foreign('schedule_id')
                  ->references('id')
                  ->on('schedule_pi_bi')
                  ->onDelete('cascade');

            // MATCH juri_profile.user_id which is BIGINT(20) unsigned
            $table->unsignedBigInteger('juri_id');
            $table->foreign('juri_id')
                  ->references('user_id')
                  ->on('juri_profile')
                  ->onDelete('cascade');

            $table->timestamps();

            $table->unique(['schedule_id','juri_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('schedule_pi_bi_juri');
    }
}
