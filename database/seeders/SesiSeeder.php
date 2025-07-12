<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SesiSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sesi')->insert([
            ['name' => 'Sesi I', 'start_time' => '08:30:00', 'end_time' => '09:30:00'],
            ['name' => 'Sesi II', 'start_time' => '09:35:00', 'end_time' => '10:35:00'],
            ['name' => 'Sesi III', 'start_time' => '10:35:00', 'end_time' => '11:35:00'],
            ['name' => 'Sesi IV', 'start_time' => '13:05:00', 'end_time' => '14:05:00'],
            ['name' => 'Sesi V', 'start_time' => '14:05:00', 'end_time' => '15:05:00'],
            ['name' => 'Sesi VI', 'start_time' => '15:05:00', 'end_time' => '16:05:00'],
        ]);
    }
}