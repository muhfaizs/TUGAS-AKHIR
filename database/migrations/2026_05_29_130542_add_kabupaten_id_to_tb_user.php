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
        Schema::table('tb_user', function (Blueprint $table) {
            $table->unsignedBigInteger('kabupaten_id')->nullable()->after('wilayah_kerja');
            // Using constrained on 'kabupatens' if the table is 'kabupatens'
            // We'll just define foreign if needed, but nullable is fine for now
            $table->foreign('kabupaten_id')->references('id')->on('kabupatens')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_user', function (Blueprint $table) {
            $table->dropForeign(['kabupaten_id']);
            $table->dropColumn('kabupaten_id');
        });
    }
};
