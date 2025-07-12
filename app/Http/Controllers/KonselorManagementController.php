<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class KonselorManagementController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'konselor') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $konselors = User::where('role', 'konselor')->get();
        return view('konselor-management.index', compact('konselors'));
    }

    public function create()
    {
        return view('konselor-management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'konselor',
            'is_admin' => false,
            'is_active' => true,
        ];
    
        // Upload dan simpan gambar jika ada
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('konselor-photos', 'public');
            $data['image'] = $imagePath;
        }
    
        User::create($data);
    
        return redirect()->route('konselor-management.index')
            ->with('success', 'Konselor berhasil ditambahkan');
    }

    public function edit(User $konselor)
    {
        return view('konselor-management.edit', compact('konselor'));
    }

    public function update(Request $request, User $konselor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $konselor->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
    
        // Cek apakah ada perubahan is_admin
        if (auth()->user()->isAdminKonselor() && $request->has('is_admin')) {
            $data['is_admin'] = (bool) $request->is_admin;
        }
    
        // Upload dan simpan gambar jika ada
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($konselor->image) {
                Storage::disk('public')->delete($konselor->image);
            }
    
            $imagePath = $request->file('image')->store('konselor-photos', 'public');
            $data['image'] = $imagePath;
        }
    
        $konselor->update($data);
    
        return redirect()->route('konselor-management.index')
            ->with('success', 'Konselor berhasil diperbarui');
    }

    public function destroy(User $konselor)
    {
        // Check if user is admin konselor to prevent deleting admin
        if ($konselor->isAdminKonselor()) {
            return back()->with('error', 'Tidak dapat menghapus admin konselor');
        }

        $konselor->delete();
        return redirect()->route('konselor-management.index')
            ->with('success', 'Konselor berhasil dihapus');
    }

        // Add method untuk toggle status
    public function toggleStatus(User $konselor)
    {
        // Check if user is admin konselor
        if (!auth()->user()->isAdminKonselor()) {
            abort(403, 'Unauthorized action.');
        }
    
        $konselor->update([
            'is_active' => !$konselor->is_active
        ]);
    
        return back()->with('success', 'Status konselor berhasil diperbarui.');
    }
}