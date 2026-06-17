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
        // Add puskesmas_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('puskesmas_id')->nullable()->after('address');
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas')->onDelete('set null');
        });

        // Add puskesmas_id foreign key to kb_acceptors
        Schema::table('kb_acceptors', function (Blueprint $table) {
            $table->foreign('puskesmas_id')->references('id')->on('puskesmas')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kb_acceptors', function (Blueprint $table) {
            $table->dropForeign(['puskesmas_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['puskesmas_id']);
            $table->dropColumn('puskesmas_id');
        });
    }
};
