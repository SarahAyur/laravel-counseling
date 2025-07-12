<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('konseling_sessions', function (Blueprint $table) {
            $table->boolean('chat_enabled')->default(false);
        });
    }

    public function down()
    {
        Schema::table('konseling_sessions', function (Blueprint $table) {
            $table->dropColumn('chat_enabled');
        });
    }
};