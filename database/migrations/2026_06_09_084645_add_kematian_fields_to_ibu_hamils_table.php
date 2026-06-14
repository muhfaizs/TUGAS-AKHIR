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
        Schema::table('ibu_hamils', function (Blueprint $table) {
            $table->integer('bayi_meninggal_setelah_lahir')->default(0)->after('abortus');
            $table->enum('status_ibu_meninggal', ['Hidup', 'Meninggal'])->default('Hidup')->after('status_pasien');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ibu_hamils', function (Blueprint $table) {
            $table->dropColumn(['bayi_meninggal_setelah_lahir', 'status_ibu_meninggal']);
        });
    }
};
