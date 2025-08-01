<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'max:20', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'whatsapp_number' => ['required', 'string', 'max:20'],
            'prodi' => ['required', 'string', 'in:Teknik Informatika,Teknik Mesin,Teknik Sipil,Teknik Elektro,Desain Komunikasi Visual,Pendidikan Guru Sekolah Dasar,Hukum,Manajemen,Akuntansi'],
            'semester' => ['required', 'string', 'in:1,2,3,4,5,6,7,8,9,>10'],
            'student_type' => ['required', 'string', 'in:Local Student,International Student'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'nim' => $request->nim,
            'email' => $request->email,
            'whatsapp_number' => $request->whatsapp_number,
            'prodi' => $request->prodi,
            'semester' => $request->semester,
            'student_type' => $request->student_type,
            'password' => Hash::make($request->password),
            'role' => 'mahasiswa',
        ]);
    
        event(new Registered($user));
    
        Auth::login($user);
    
        return redirect(route('dashboard', absolute: false));
    }
}
