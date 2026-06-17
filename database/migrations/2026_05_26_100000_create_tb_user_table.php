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
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('nama_lengkap');
            $table->string('nomor_kontak')->nullable();
            $table->string('role')->default('orang tua');
            $table->string('nip_bidan')->nullable();
            $table->unsignedBigInteger('id_posyandu_kader')->nullable();
            $table->string('nik_ortu')->nullable();
            $table->string('kode_instansi_dinkes')->nullable();
            $table->json('hak_akses_master')->nullable();
            $table->json('log_aktivitas')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_user');
    }
};
