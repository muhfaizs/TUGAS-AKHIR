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
        Schema::table('pemeriksaan_ancs', function (Blueprint $table) {
            $table->time('waktu_pemeriksaan')->nullable()->after('tanggal_pemeriksaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_ancs', function (Blueprint $table) {
            $table->dropColumn('waktu_pemeriksaan');
        });
    }
};
