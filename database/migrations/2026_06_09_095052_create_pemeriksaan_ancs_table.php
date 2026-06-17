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
        Schema::create('pemeriksaan_ancs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ibu_hamil_id')->constrained()->cascadeOnDelete();

            // Info Dasar
            $table->date('tanggal_pemeriksaan');
            $table->integer('usia_kehamilan_minggu')->nullable();
            $table->text('keluhan_utama')->nullable();

            // T1 - T3 Fisik
            $table->decimal('berat_badan', 5, 2)->nullable(); // kg
            $table->decimal('tinggi_badan', 5, 2)->nullable(); // cm
            $table->string('tekanan_darah', 20)->nullable(); // 120/80
            $table->decimal('lingkar_lengan_atas', 5, 2)->nullable(); // cm

            // T4 - T5 Kebidanan
            $table->decimal('tinggi_fundus_uteri', 5, 2)->nullable(); // cm
            $table->string('letak_janin', 50)->nullable(); // Kep/LetSu/LetLi
            $table->integer('denyut_jantung_janin')->nullable(); // bpm

            // T6 - T7 Imunisasi & Suplemen
            $table->string('status_imunisasi_tt', 10)->nullable(); // T1, T2, T3...
            $table->boolean('diberikan_imunisasi_tt')->default(false);
            $table->boolean('diberikan_tablet_tambah_darah')->default(false);
            $table->integer('jumlah_tablet_darah')->nullable();

            // T8 Laboratorium
            $table->boolean('rujuk_laboratorium')->default(false);
            $table->decimal('lab_hb', 5, 2)->nullable();
            $table->string('lab_protein_urine', 50)->nullable();
            $table->string('lab_golongan_darah', 5)->nullable();
            $table->string('lab_hiv', 20)->nullable(); // Reaktif / Non-Reaktif
            $table->string('lab_sifilis', 20)->nullable(); // Reaktif / Non-Reaktif
            $table->string('lab_hepatitis_b', 20)->nullable(); // Reaktif / Non-Reaktif
            $table->text('catatan_lab')->nullable();

            // T11 USG
            $table->text('hasil_usg')->nullable();

            // T9 - T10 Penanganan & Konseling
            $table->boolean('ditemukan_risiko')->default(false);
            $table->text('tatalaksana_kasus')->nullable();
            $table->text('konseling')->nullable();
            $table->text('skrining_jiwa')->nullable();

            $table->boolean('diinput_ke_sigizi')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemeriksaan_ancs');
    }
};
