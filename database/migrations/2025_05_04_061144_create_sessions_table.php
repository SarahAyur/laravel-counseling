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
        Schema::create('sesi', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama sesi (misalnya, "Sesi I")
            $table->time('start_time'); // Waktu mulai
            $table->time('end_time'); // Waktu selesai
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sesi');
    }
};