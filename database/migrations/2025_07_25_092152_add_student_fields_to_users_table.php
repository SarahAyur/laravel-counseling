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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nim')->nullable()->after('name');
            $table->string('whatsapp_number')->nullable()->after('email');
            $table->enum('prodi', [
                'Teknik Informatika', 'Teknik Mesin', 'Teknik Sipil', 
                'Teknik Elektro', 'Desain Komunikasi Visual', 
                'Pendidikan Guru Sekolah Dasar', 'Hukum', 
                'Manajemen', 'Akuntansi'
            ])->nullable()->after('whatsapp_number');
            $table->enum('semester', [
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '>10'
            ])->nullable()->after('prodi');
            $table->enum('student_type', [
                'Local Student', 'International Student'
            ])->nullable()->after('semester');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nim');
            $table->dropColumn('whatsapp_number');
            $table->dropColumn('prodi');
            $table->dropColumn('semester');
            $table->dropColumn('student_type');
        });
    }
};