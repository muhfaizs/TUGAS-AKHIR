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
        Schema::table('kb_services', function (Blueprint $table) {
            if (Schema::hasColumn('kb_services', 'akseptor_id')) {
                $table->dropUnique('kb_services_akseptor_id_unique');
                $table->dropColumn('akseptor_id');
            }
            if (Schema::hasColumn('kb_services', 'akseptor_name')) {
                $table->dropColumn('akseptor_name');
            }
            if (Schema::hasColumn('kb_services', 'puskesmas')) {
                $table->dropColumn('puskesmas');
            }
            if (Schema::hasColumn('kb_services', 'service_date')) {
                $table->date('service_date')->nullable()->change();
            } else {
                $table->date('service_date')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kb_services', function (Blueprint $table) {
            // Revert changes
            $table->string('akseptor_id')->nullable();
            $table->string('akseptor_name')->nullable();
            $table->string('puskesmas')->nullable();
        });
    }
};
