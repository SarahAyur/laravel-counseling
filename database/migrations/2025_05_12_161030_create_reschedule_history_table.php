<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reschedule_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konseling_id')->constrained('konseling_sessions')->onDelete('cascade');
            $table->date('old_tanggal');
            $table->foreignId('old_sesi_id')->constrained('sesi')->onDelete('cascade');
            $table->date('new_tanggal');
            $table->foreignId('new_sesi_id')->constrained('sesi')->onDelete('cascade');
            $table->string('status')->default('pending'); // pending, approved, canceled
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reschedule_history');
    }
};