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
        Schema::create('ibu_hamils', function (Blueprint $table) {
            $table->id();

            // Data Identitas Pasien
            $table->string('nik', 16)->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->integer('umur');
            $table->text('alamat');
            $table->string('nomor_telepon');
            $table->string('email')->nullable();
            $table->string('nama_suami');
            $table->string('pekerjaan')->nullable();
            $table->enum('golongan_darah', ['A', 'B', 'AB', 'O', 'Tidak Tahu'])->default('Tidak Tahu');

            // Data Kehamilan Dasar
            $table->date('hpht'); // Hari Pertama Haid Terakhir
            $table->date('hpl');  // Hari Perkiraan Lahir
            $table->integer('usia_kehamilan'); // dalam minggu
            $table->integer('gravida'); // G
            $table->integer('paritas'); // P
            $table->integer('abortus'); // A
            $table->integer('kehamilan_ke');
            $table->enum('status_risiko_kehamilan', ['Rendah', 'Tinggi', 'Sangat Tinggi'])->default('Rendah');

            // Data Administratif
            $table->date('tanggal_registrasi_pasien');
            $table->enum('status_pasien', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->foreignId('bidan_id')->constrained('users')->onDelete('cascade');
            $table->string('nomor_rekam_medis')->unique();

            // Riwayat Singkat Pasien
            $table->integer('jumlah_pemeriksaan_anc')->default(0);
            $table->date('pemeriksaan_terakhir')->nullable();
            $table->string('status_kehamilan_terakhir')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ibu_hamils');
    }
};
