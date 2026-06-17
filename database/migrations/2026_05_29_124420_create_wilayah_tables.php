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
        Schema::create('kabupatens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kabupaten');
            $table->timestamps();
        });

        if (!Schema::hasTable('puskesmas')) {
            Schema::create('puskesmas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('kabupaten_id')->constrained('kabupatens')->onDelete('cascade');
                $table->string('nama_puskesmas');
                $table->timestamps();
            });
        } else {
            Schema::table('puskesmas', function (Blueprint $table) {
                if (!Schema::hasColumn('puskesmas', 'kabupaten_id')) {
                    $table->foreignId('kabupaten_id')->nullable()->constrained('kabupatens')->onDelete('cascade');
                }
                if (!Schema::hasColumn('puskesmas', 'nama_puskesmas')) {
                    $table->string('nama_puskesmas')->nullable();
                }
            });
        }

        Schema::create('posyandus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('puskesmas_id')->constrained('puskesmas')->onDelete('cascade');
            $table->string('nama_posyandu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posyandus');
        Schema::dropIfExists('puskesmas');
        Schema::dropIfExists('kabupatens');
    }
};
