<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('name');
            $table->string('nik', 16)->nullable()->unique()->after('username');
            
            // Allow patient in enum role if not exists
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin','bidan','upt_kb','kader','patient','dinas_kesehatan') DEFAULT 'patient'");
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'nik']);
        });
    }
};
