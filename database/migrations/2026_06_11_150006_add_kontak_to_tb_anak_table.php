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
        Schema::table('tb_anak', function (Blueprint $table) {
            $table->text('alamat_domisili')->nullable();
            $table->string('nomor_kontak_darurat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_anak', function (Blueprint $table) {
            $table->dropColumn(['alamat_domisili', 'nomor_kontak_darurat']);
        });
    }
};
