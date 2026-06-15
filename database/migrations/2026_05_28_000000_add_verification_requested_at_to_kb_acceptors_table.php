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
        Schema::table('kb_acceptors', function (Blueprint $table) {
            $table->timestamp('verification_requested_at')->nullable()->after('registered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kb_acceptors', function (Blueprint $table) {
            $table->dropColumn('verification_requested_at');
        });
    }
};
