<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSkorCuToCuSelectionTable extends Migration
{
    /**
     * Jalankan migrasi: tambah kolom skor_cu.
     */
    public function up(): void
    {
        Schema::table('cu_selection', function (Blueprint $table) {
            $table->decimal('skor_cu', 5, 4)->default(0.0000)->after('status_lolos');
        });
    }

    /**
     * Rollback migrasi: hapus kolom skor_cu.
     */
    public function down(): void
    {
        Schema::table('cu_selection', function (Blueprint $table) {
            $table->dropColumn('skor_cu');
        });
    }
}
