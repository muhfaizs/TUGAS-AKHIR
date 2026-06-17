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
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code', 10)->unique();
            $table->text('address');
            $table->string('village');
            $table->string('district');
            $table->string('sub_district');
            $table->string('postal_code', 10);
            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('head_of_puskesmas')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();
            
            $table->index('name');
            $table->index('district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('puskesmas');
    }
};
