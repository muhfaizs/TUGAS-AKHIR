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
        Schema::create('tb_tindakan_medis', function (Blueprint $table) {
            $table->id('id_tindakan');
            $table->unsignedBigInteger('id_anak');
            $table->unsignedBigInteger('id_bidan');
            $table->date('tanggal_pemeriksaan');
            $table->text('catatan_pemeriksaan')->nullable();
            $table->text('diagnosa')->nullable();
            $table->timestamps();

            $table->foreign('id_anak')->references('id_anak')->on('tb_anak')->cascadeOnDelete();
            $table->foreign('id_bidan')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tindakan_medis');
    }
};

