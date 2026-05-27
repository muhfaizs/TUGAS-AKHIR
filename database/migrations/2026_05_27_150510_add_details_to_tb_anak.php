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
            $table->string('no_bpjs', 20)->nullable()->after('nik_anak');
            $table->integer('anak_ke')->nullable()->after('nama_anak');
            $table->string('golongan_darah', 5)->nullable()->after('jenis_kelamin');
            $table->decimal('lingkar_kepala_lahir', 5, 2)->nullable()->comment('Dalam cm')->after('panjang_lahir');
            $table->string('kondisi_lahir')->nullable()->comment('Misal: Normal, Prematur, dll')->after('lingkar_kepala_lahir');
            $table->text('riwayat_alergi')->nullable()->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_anak', function (Blueprint $table) {
            $table->dropColumn([
                'no_bpjs',
                'anak_ke',
                'golongan_darah',
                'lingkar_kepala_lahir',
                'kondisi_lahir',
                'riwayat_alergi'
            ]);
        });
    }
};
