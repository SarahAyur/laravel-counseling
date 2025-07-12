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

            $table->dropForeign(['konselor_id']);

            // Hapus foreign key sementara untuk sesi_id
            $table->dropForeign(['sesi_id']);

            // Hapus constraint unik lama
            $table->dropUnique('unique_konselor_schedule');

            // Tambahkan constraint unik baru
            $table->unique(['konselor_id', 'tanggal', 'sesi_id'], 'unique_konselor_schedule');

            // Tambahkan kembali foreign key untuk sesi_id
            $table->foreign('sesi_id')->references('id')->on('sesi')->onDelete('cascade');

            // Tambahkan kembali foreign key untuk konselor_id
            $table->foreign('konselor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('konseling_sessions', function (Blueprint $table) {
            // Hapus foreign key untuk konselor_id
            $table->dropForeign(['konselor_id']);
            // Hapus foreign key sementara untuk sesi_id
            $table->dropForeign(['sesi_id']);

            // Hapus constraint unik baru
            $table->dropUnique('unique_konselor_schedule');

            // Tambahkan kembali constraint unik lama
            $table->unique(['konselor_id', 'tanggal'], 'unique_konselor_schedule');

            // Tambahkan kembali foreign key untuk sesi_id
            $table->foreign('sesi_id')->references('id')->on('sesi')->onDelete('cascade');

            // Tambahkan kembali foreign key untuk konselor_id
            $table->foreign('konselor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};