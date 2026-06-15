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
        Schema::create('follow_ups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kb_service_id')->constrained('kb_services')->onDelete('cascade');
            $table->foreignId('kb_acceptor_id')->constrained('kb_acceptors')->onDelete('cascade');
            $table->date('follow_up_date');
            $table->enum('attendance_status', ['hadir', 'tidak_hadir']);
            $table->string('condition')->nullable();
            $table->text('complaints')->nullable();
            $table->text('side_effects')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['belum_selesai', 'selesai'])->default('selesai');
            $table->date('next_control_date')->nullable();
            $table->text('next_control_notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follow_ups');
    }
};
