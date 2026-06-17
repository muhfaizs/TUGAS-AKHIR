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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [
                'super_admin',
                'bidan',
                'upt_kb',
                'kader',
                'patient',
                'dinas_kesehatan'
            ])->default('patient')->after('password');
            
            $table->enum('status', ['active', 'inactive', 'verified'])->default('inactive')->after('role');
            $table->string('phone', 20)->nullable()->after('status');
            $table->text('address')->nullable()->after('phone');
            // Will add puskesmas_id foreign key later after puskesmas table is created
            $table->string('profile_photo_path')->nullable()->after('address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'status', 'phone', 'address', 'profile_photo_path']);
        });
    }
};
