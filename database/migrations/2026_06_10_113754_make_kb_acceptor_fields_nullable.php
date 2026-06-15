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
            $table->date('date_of_birth')->nullable()->change();
            $table->integer('age')->nullable()->change();
            $table->enum('gender', ['M', 'F'])->nullable()->change();
            $table->enum('marital_status', ['Kawin', 'Belum Kawin', 'Cerai'])->nullable()->change();
            $table->text('address')->nullable()->change();
            $table->string('village')->nullable()->change();
            $table->string('district')->nullable()->change();
            $table->string('sub_district')->nullable()->change();
            $table->string('postal_code', 10)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kb_acceptors', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable(false)->change();
            $table->integer('age')->nullable(false)->change();
            $table->enum('gender', ['M', 'F'])->nullable(false)->change();
            $table->enum('marital_status', ['Kawin', 'Belum Kawin', 'Cerai'])->nullable(false)->default('Kawin')->change();
            $table->text('address')->nullable(false)->change();
            $table->string('village')->nullable(false)->change();
            $table->string('district')->nullable(false)->change();
            $table->string('sub_district')->nullable(false)->change();
            $table->string('postal_code', 10)->nullable(false)->change();
        });
    }
};
