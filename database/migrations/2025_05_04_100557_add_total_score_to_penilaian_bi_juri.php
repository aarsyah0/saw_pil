<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('penilaian_bi_juri', function (Blueprint $table) {
        $table->decimal('total_score', 5, 2)
              ->after('overall_perf_score')
              ->nullable()
              ->comment('Total skor BI (maks 100 poin)');
    });
}

public function down()
{
    Schema::table('penilaian_bi_juri', function (Blueprint $table) {
        $table->dropColumn('total_score');
    });
}

};
