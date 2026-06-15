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
        Schema::create('kb_services', function (Blueprint $table) {
            $table->id();
            $table->string('akseptor_id')->unique();
            $table->string('akseptor_name');
            $table->string('service_method'); // IUD, Implan, Suntik, Pil, Kondom, MOW, MOP
            $table->enum('status', ['Aktif', 'Ganti Metode', 'Drop Out'])->default('Aktif');
            $table->string('puskesmas');
            $table->date('service_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kb_services');
    }
};
