<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cu_selection', function (Blueprint $table) {
            $table->unsignedBigInteger('submission_id')->after('id')->nullable();
            $table->unique(['submission_id']); // supaya tiap submission hanya sekali disimpan
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cu_selection', function (Blueprint $table) {
            //
        });
    }
};
