<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ],
        ];

        if ($this->user()->role === 'mahasiswa') {
            $rules = array_merge($rules, [
                'nim' => ['required', 'string', 'max:20', Rule::unique(User::class)->ignore($this->user()->id)],
                'whatsapp_number' => ['required', 'string', 'max:20'],
                'prodi' => ['required', 'string', 'in:Teknik Informatika,Teknik Mesin,Teknik Sipil,Teknik Elektro,Desain Komunikasi Visual,Pendidikan Guru Sekolah Dasar,Hukum,Manajemen,Akuntansi'],
                'semester' => ['required', 'string', 'in:1,2,3,4,5,6,7,8,9,>10'],
                'student_type' => ['required', 'string', 'in:Local Student,International Student'],
            ]);
        }

        return $rules;
    }
}