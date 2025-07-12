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
        Schema::create('konseling_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('konselor_id')->constrained('users')->onDelete('cascade');
            $table->date('tanggal');
            $table->time('waktu');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->string('topik');
            $table->text('catatan_konselor')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling_sessions');
    }
};