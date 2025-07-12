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
        Schema::table('konseling_sessions', function (Blueprint $table) {
            $table->unique(['konselor_id', 'tanggal', 'waktu'], 'unique_konselor_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konseling_sessions', function (Blueprint $table) {
            $table->dropUnique('unique_konselor_schedule');
        });
    }
};