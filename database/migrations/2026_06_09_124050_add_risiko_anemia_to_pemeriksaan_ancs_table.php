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
        Schema::table('pemeriksaan_ancs', function (Blueprint $table) {
            $table->string('risiko_anemia', 20)->nullable()->after('jumlah_tablet_darah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemeriksaan_ancs', function (Blueprint $table) {
            $table->dropColumn('risiko_anemia');
        });
    }
};
