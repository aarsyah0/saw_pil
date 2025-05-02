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
            $table->boolean('pending')->default(false)->after('status_lolos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cu_selection', function (Blueprint $table) {
            $table->dropColumn('pending');
        });
    }
};
