<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixCuSelectionUniqueKeys extends Migration
{
    public function up(): void
    {
        Schema::table('cu_selection', function (Blueprint $table) {
            // 1) drop unique key on peserta_id & selection_round
            $table->dropUnique('uq_selection');

            // 2) add unique key on submission_id
            $table->unique('submission_id', 'uq_cu_selection_submission');
        });
    }

    public function down(): void
    {
        Schema::table('cu_selection', function (Blueprint $table) {
            // rollback: drop the new unique, restore the old one
            $table->dropUnique('uq_cu_selection_submission');
            $table->unique(['peserta_id','selection_round'], 'uq_selection');
        });
    }
}
