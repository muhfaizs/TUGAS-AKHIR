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
        Schema::table('tb_tindakan_medis', function (Blueprint $table) {
            $table->decimal('suhu_tubuh', 4, 1)->nullable()->after('tanggal_pemeriksaan');
            $table->text('resep_obat')->nullable()->after('diagnosa');
        });

        Schema::table('tb_imunisasi', function (Blueprint $table) {
            $table->string('batch_vaksin')->nullable()->after('nama_vaksin');
            $table->string('lokasi_suntikan')->nullable()->after('batch_vaksin');
            $table->decimal('suhu_tubuh', 4, 1)->nullable()->after('lokasi_suntikan');
            $table->text('catatan')->nullable()->after('suhu_tubuh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_tindakan_medis', function (Blueprint $table) {
            $table->dropColumn(['suhu_tubuh', 'resep_obat']);
        });

        Schema::table('tb_imunisasi', function (Blueprint $table) {
            $table->dropColumn(['batch_vaksin', 'lokasi_suntikan', 'suhu_tubuh', 'catatan']);
        });
    }
};
