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
        Schema::dropIfExists('chats');
        Schema::dropIfExists('students');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu mengembalikan tabel yang dihapus
        // karena kemungkinan strukturnya sudah berubah
    }
};