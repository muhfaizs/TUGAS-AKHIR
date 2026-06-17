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
        Schema::create('kb_acceptors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('nik', 16)->unique()->comment('Nomor Induk Kependudukan');
            $table->string('kk_number', 16)->nullable()->comment('Nomor Kartu Keluarga');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->integer('age');
            $table->enum('gender', ['M', 'F']);
            $table->enum('marital_status', ['Kawin', 'Belum Kawin', 'Cerai'])->default('Kawin');
            $table->enum('education', ['TK', 'SD', 'SMP', 'SMA', 'Diploma', 'S1', 'S2'])->nullable();
            $table->string('occupation')->nullable();
            $table->string('religion')->nullable();
            $table->string('phone', 20);
            $table->string('email')->nullable()->unique();
            $table->string('blood_type', 3)->nullable();
            $table->text('health_history')->nullable();
            $table->text('allergies')->nullable();
            $table->decimal('bmi', 5, 2)->nullable();
            
            // Address Information
            $table->text('address');
            $table->string('village');
            $table->string('district');
            $table->string('sub_district');
            $table->string('postal_code', 10);
            
            // Photos
            $table->string('photo_nik_path')->nullable();
            $table->string('photo_profile_path')->nullable();
            
            // Registration Info
            $table->foreignId('registered_by')->nullable()->constrained('users')->onDelete('set null')->comment('Bidan/Kader ID');
            $table->timestamp('registered_at');
            $table->unsignedBigInteger('puskesmas_id')->nullable();  // Will add foreign key in separate migration
            $table->foreignId('kader_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Status
            $table->enum('status', ['active', 'inactive', 'transferred', 'graduated'])->default('active');
            $table->boolean('is_verified')->default(false);
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            
            // Metadata
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('nik');
            $table->index('phone');
            $table->index('email');
            $table->index('status');
            $table->index('puskesmas_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kb_acceptors');
    }
};
