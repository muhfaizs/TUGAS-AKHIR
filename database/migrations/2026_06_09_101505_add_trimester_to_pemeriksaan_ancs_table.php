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
            $table->string('trimester', 20)->nullable()->after('tanggal_pemeriksaan');
            $table->dropColumn('usia_kehamilan_minggu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_ancs', function (Blueprint $table) {
            $table->integer('usia_kehamilan_minggu')->nullable()->after('tanggal_pemeriksaan');
            $table->dropColumn('trimester');
        });
    }
};
