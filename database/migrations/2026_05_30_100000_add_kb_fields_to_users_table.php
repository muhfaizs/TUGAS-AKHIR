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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'id_posyandu_kader')) {
                $table->string('id_posyandu_kader')->nullable();
            }
            if (!Schema::hasColumn('users', 'kabupaten_id')) {
                $table->foreignId('kabupaten_id')->nullable()->constrained('kabupatens')->onDelete('set null');
            }
            if (!Schema::hasColumn('users', 'kode_instansi_dinkes')) {
                $table->string('kode_instansi_dinkes')->nullable();
            }
            if (!Schema::hasColumn('users', 'hak_akses_master')) {
                $table->json('hak_akses_master')->nullable();
            }
            if (!Schema::hasColumn('users', 'log_aktivitas')) {
                $table->json('log_aktivitas')->nullable();
            }
            if (!Schema::hasColumn('users', 'wilayah_kerja')) {
                $table->string('wilayah_kerja')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'kabupaten_id')) {
                $table->dropForeign(['kabupaten_id']);
                $table->dropColumn('kabupaten_id');
            }
            $table->dropColumn([
                'id_posyandu_kader',
                'kode_instansi_dinkes',
                'hak_akses_master',
                'log_aktivitas',
                'wilayah_kerja',
            ]);
        });
    }
};
