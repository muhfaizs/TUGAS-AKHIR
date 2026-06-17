<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('super_admin', 'bidan', 'upt_kb', 'kader', 'patient', 'dinas_kesehatan', 'ortu', 'dinkes') DEFAULT 'ortu'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('bidan', 'ortu') DEFAULT 'ortu'");
    }
};
