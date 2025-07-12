<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('feedbacks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sesi_id')->constrained('konseling_sessions')->onDelete('cascade');
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating');
            $table->text('komentar');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('feedbacks');
    }
};