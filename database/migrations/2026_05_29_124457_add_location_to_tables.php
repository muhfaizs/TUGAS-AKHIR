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
        Schema::table('tb_user', function (Blueprint $table) {
            $table->foreignId('puskesmas_id')->nullable()->constrained('puskesmas')->onDelete('set null');
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandus')->onDelete('set null');
        });

        Schema::table('tb_tindakan_medis', function (Blueprint $table) {
            $table->foreignId('puskesmas_id')->nullable()->constrained('puskesmas')->onDelete('set null');
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandus')->onDelete('set null');
        });

        Schema::table('tb_imunisasi', function (Blueprint $table) {
            $table->foreignId('puskesmas_id')->nullable()->constrained('puskesmas')->onDelete('set null');
            $table->foreignId('posyandu_id')->nullable()->constrained('posyandus')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_imunisasi', function (Blueprint $table) {
            $table->dropForeign(['puskesmas_id']);
            $table->dropForeign(['posyandu_id']);
            $table->dropColumn(['puskesmas_id', 'posyandu_id']);
        });

        Schema::table('tb_tindakan_medis', function (Blueprint $table) {
            $table->dropForeign(['puskesmas_id']);
            $table->dropForeign(['posyandu_id']);
            $table->dropColumn(['puskesmas_id', 'posyandu_id']);
        });

        Schema::table('tb_user', function (Blueprint $table) {
            $table->dropForeign(['puskesmas_id']);
            $table->dropForeign(['posyandu_id']);
            $table->dropColumn(['puskesmas_id', 'posyandu_id']);
        });
    }
};
