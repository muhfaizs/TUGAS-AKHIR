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
        Schema::table('follow_ups', function (Blueprint $table) {
            $table->string('absence_reason')->nullable()->after('attendance_status');
            $table->string('risk_level')->nullable()->after('side_effects');
            $table->text('danger_signs')->nullable()->after('risk_level');
            $table->text('bidan_actions')->nullable()->after('notes');
            $table->string('kb_method_decision')->nullable()->after('bidan_actions');
            $table->string('new_kb_method')->nullable()->after('kb_method_decision');
            $table->string('method_change_reason')->nullable()->after('new_kb_method');
            // Change enum to string for status to support new options safely
            // Note: DBAL might be needed for enum change, but in SQLite it works, in MySQL it might need a raw query or just string()->change().
            // We'll change it to string.
            $table->string('status')->default('Belum Ditindaklanjuti')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('follow_ups', function (Blueprint $table) {
            $table->dropColumn([
                'absence_reason',
                'risk_level',
                'danger_signs',
                'bidan_actions',
                'kb_method_decision',
                'new_kb_method',
                'method_change_reason',
            ]);
            // Can't easily revert string back to enum securely without data loss, so we'll leave status as string.
        });
    }
};
