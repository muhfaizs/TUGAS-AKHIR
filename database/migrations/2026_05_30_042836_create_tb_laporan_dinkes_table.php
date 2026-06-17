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
        Schema::create('tb_laporan_dinkes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bidan');
            $table->string('nama_puskesmas');
            $table->date('periode_awal');
            $table->date('periode_akhir');
            $table->string('status')->default('Terkirim');
            $table->longText('data_serialized')->nullable();
            $table->timestamps();

            $table->foreign('id_bidan')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_laporan_dinkes');
    }
};

