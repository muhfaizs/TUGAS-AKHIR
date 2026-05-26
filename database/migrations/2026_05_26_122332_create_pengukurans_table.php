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
        Schema::create('tb_pengukuran', function (Blueprint $table) {
            $table->id('id_pengukuran');
            $table->unsignedBigInteger('id_anak');
            $table->unsignedBigInteger('id_kader');
            $table->date('tanggal_pengukuran');
            $table->float('berat_badan');
            $table->float('tinggi_badan');
            $table->float('lingkar_kepala')->nullable();
            $table->float('imt')->nullable();
            $table->boolean('flag_risiko')->default(0);
            $table->timestamps();

            $table->foreign('id_anak')->references('id_anak')->on('tb_anak')->onDelete('cascade');
            $table->foreign('id_kader')->references('id_user')->on('tb_user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_pengukuran');
    }
};
