<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil data konselor yang aktif
        $konselors = User::where('role', 'konselor')
                        ->where('is_active', true)
                        ->get();
        
        return view('welcome', compact('konselors'));
    }
}