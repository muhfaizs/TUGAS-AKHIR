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
        Schema::create('tb_imunisasi', function (Blueprint $table) {
            $table->id('id_imunisasi');
            $table->unsignedBigInteger('id_anak');
            $table->unsignedBigInteger('id_bidan');
            $table->string('nama_vaksin');
            $table->date('tanggal_pemberian');
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
        Schema::dropIfExists('tb_imunisasi');
    }
};

