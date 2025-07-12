<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat Admin Konselor
        User::create([
            'name' => 'Admin Konselor',
            'email' => 'sarahayurahmawati@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'konselor',
            'is_admin' => true,
            'is_active' => true,
        ]);
        
        // Membuat Konselor Regular
        User::create([
            'name' => 'Konselor Regular',
            'email' => 'quotablelifeofficial@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'konselor',
            'is_admin' => false,
            'is_active' => true,
        ]);
        
        // Membuat Mahasiswa
        User::create([
            'name' => 'Sarah Ayu Rahmawati',
            'email' => 'lestariayu23525@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
            'is_admin' => false,
            'is_active' => true,
        ]);

        // Panggil seeder lain
        $this->call([
            SesiSeeder::class,
            FormQuestionSeeder::class,
        ]);
    }
}