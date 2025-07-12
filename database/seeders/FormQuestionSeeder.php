<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormQuestionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('form_questions')->insert([
            [
                'pertanyaan' => 'Name',
                'tipe' => 'text',
                'opsi' => null,
                'urutan' => 1,
            ],
            [
                'pertanyaan' => 'WhatsApp Number',
                'tipe' => 'text',
                'opsi' => null,
                'urutan' => 2,
            ],
            [
                'pertanyaan' => 'NIM',
                'tipe' => 'text',
                'opsi' => null,
                'urutan' => 3,
            ],
            [
                'pertanyaan' => 'Prodi',
                'tipe' => 'select',
                'opsi' => 'Teknik Informatika, Teknik Mesin, Teknik Sipil, Teknik Elektro, Desain Komunikasi Visual, Pendidikan Guru Sekolah Dasar, Hukum, Manajemen, Akuntansi',
                'urutan' => 4,
            ],
            [
                'pertanyaan' => 'Semester',
                'tipe' => 'select',
                'opsi' => '1,2,3,4,5,6,7,8,9,>10',
                'urutan' => 5,
            ],
            [
                'pertanyaan' => 'Mahasiswa',
                'tipe' => 'radio',
                'opsi' => 'Local Student, International Student',
                'urutan' => 6,
            ],
            [
                'pertanyaan' => 'Pertemuan',
                'tipe' => 'radio',
                'opsi' => 'Baru, Lanjutan',
                'urutan' => 7,
            ],
            [
                'pertanyaan' => 'Apa yang Anda rasakan akhir-akhir ini? Silahkan ceritakan secara singkat permasalahan atau kondisi yang sedang dihadapi / What have you been feeling lately? Please briefly describe the problem or condition that you are facing.',
                'tipe' => 'textarea',
                'opsi' => null,
                'urutan' => 8,
            ],
            [
                'pertanyaan' => 'Sejak kapan Anda merasakan hal tersebut, dan siapa saja pihak yang terlibat dalam masalah tersebut? / Since when have you felt this way, and who are the parties involved in this problem?',
                'tipe' => 'textarea',
                'opsi' => null,
                'urutan' => 9,
            ],
            [
                'pertanyaan' => 'Apa yang sudah Anda lakukan untuk menyelesaikan masalah tersebut (jika ada)? / What have you done to resolve the problem (if any)?',
                'tipe' => 'textarea',
                'opsi' => null,
                'urutan' => 10,
            ],
        ]);
    }
}