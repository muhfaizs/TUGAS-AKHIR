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
            if (!Schema::hasColumn('kb_services', 'kb_acceptor_id')) {
            $table->foreignId('kb_acceptor_id')->nullable()->after('id')->constrained('kb_acceptors')->onDelete('set null');
            }

            if (!Schema::hasColumn('kb_services', 'bidan_id')) {
            $table->foreignId('bidan_id')->nullable()->after('kb_acceptor_id')->constrained('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('kb_services', 'puskesmas_id')) {
            $table->foreignId('puskesmas_id')->nullable()->after('bidan_id')->constrained('puskesmas')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('kb_services', 'location')) {
                $table->enum('location', ['puskesmas', 'kader', 'rumah', 'posyandu'])->default('puskesmas')->after('puskesmas_id');
            }

            if (!Schema::hasColumn('kb_services', 'batch_number')) {
                $table->string('batch_number')->nullable()->after('service_method');
            }

            if (!Schema::hasColumn('kb_services', 'blood_pressure')) {
                $table->string('blood_pressure')->nullable()->after('batch_number');
            }

            if (!Schema::hasColumn('kb_services', 'weight')) {
                $table->decimal('weight', 5, 2)->nullable()->after('blood_pressure');
            }

            if (!Schema::hasColumn('kb_services', 'clinical_findings')) {
                $table->text('clinical_findings')->nullable()->after('weight');
            }

            if (!Schema::hasColumn('kb_services', 'contraindication')) {
                $table->text('contraindication')->nullable()->after('clinical_findings');
            }

            if (!Schema::hasColumn('kb_services', 'side_effects')) {
                $table->text('side_effects')->nullable()->after('contraindication');
            }

            if (!Schema::hasColumn('kb_services', 'follow_up_date')) {
                $table->date('follow_up_date')->nullable()->after('side_effects');
            }

            if (!Schema::hasColumn('kb_services', 'follow_up_type')) {
                $table->enum('follow_up_type', ['phone', 'visit'])->nullable()->after('follow_up_date');
            }

            if (!Schema::hasColumn('kb_services', 'notes')) {
                $table->text('notes')->nullable()->after('follow_up_type');
            }
            
            if (!Schema::hasColumn('kb_services', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('notes');
            }

            if (!Schema::hasColumn('kb_services', 'verified_by')) {
                $table->foreignId('verified_by')->nullable()->after('is_verified')->constrained('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('kb_services', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verified_by');
            }
            
            if (!Schema::hasColumn('kb_services', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('verified_at')->constrained('users')->onDelete('set null');
            }

            if (!Schema::hasColumn('kb_services', 'updated_by')) {
                $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('kb_services', 'deleted_at')) {
                $table->softDeletes();
            }
            
            // Indexes
            if (!Schema::hasIndex('kb_services', 'kb_services_kb_acceptor_id_index')) {
                $table->index('kb_acceptor_id');
            }
            if (!Schema::hasIndex('kb_services', 'kb_services_bidan_id_index')) {
                $table->index('bidan_id');
            }
            if (!Schema::hasIndex('kb_services', 'kb_services_puskesmas_id_index')) {
                $table->index('puskesmas_id');
            }
            if (!Schema::hasIndex('kb_services', 'kb_services_status_index')) {
                $table->index('status');
            }
            if (!Schema::hasIndex('kb_services', 'kb_services_service_date_index')) {
                $table->index('service_date');
            }
            if (!Schema::hasIndex('kb_services', 'kb_services_follow_up_date_index')) {
                $table->index('follow_up_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kb_services', function (Blueprint $table) {
            if (Schema::hasColumn('kb_services', 'kb_acceptor_id')) {
                $table->dropForeign(['kb_acceptor_id']);
                $table->dropColumn('kb_acceptor_id');
            }
            if (Schema::hasColumn('kb_services', 'bidan_id')) {
                $table->dropForeign(['bidan_id']);
                $table->dropColumn('bidan_id');
            }
            if (Schema::hasColumn('kb_services', 'puskesmas_id')) {
                $table->dropForeign(['puskesmas_id']);
                $table->dropColumn('puskesmas_id');
            }
            if (Schema::hasColumn('kb_services', 'verified_by')) {
                $table->dropForeign(['verified_by']);
                $table->dropColumn('verified_by');
            }
            if (Schema::hasColumn('kb_services', 'created_by')) {
                $table->dropForeign(['created_by']);
                $table->dropColumn('created_by');
            }
            if (Schema::hasColumn('kb_services', 'updated_by')) {
                $table->dropForeign(['updated_by']);
                $table->dropColumn('updated_by');
            }

            $table->dropColumn([
                'location', 'batch_number', 'blood_pressure', 'weight',
                'clinical_findings', 'contraindication', 'side_effects',
                'follow_up_date', 'follow_up_type', 'notes',
                'is_verified', 'verified_at',
                'deleted_at'
            ]);
        });
    }
};
