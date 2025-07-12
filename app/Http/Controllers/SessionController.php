<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'konselor') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        $sessions = Session::orderBy('start_time')->get();
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        Session::create($request->all());
        return redirect()->route('sessions.index')->with('success', 'Sesi berhasil ditambahkan.');
    }

    public function edit(Session $session)
    {
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
        ]);

        $session->update($validated);
        return redirect()->route('sessions.index')
            ->with('success', 'Sesi berhasil diperbarui.');
            
    } catch (\Exception $e) {
        \Log::error('Session update error: ' . $e->getMessage());
        return back()
            ->withInput()
            ->withErrors(['error' => 'Gagal memperbarui sesi. ' . $e->getMessage()]);
    }
}
    public function destroy(Session $session)
    {
        $session->delete();
        return redirect()->route('sessions.index')->with('success', 'Sesi berhasil dihapus.');
    }
}