<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\KonselingSession;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function create($sesi_id)
    {
        $session = KonselingSession::findOrFail($sesi_id);
        
        if ($session->mahasiswa_id !== auth()->id()) {
            abort(403);
        }

        return view('feedback.create', compact('session'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sesi_id' => 'required|exists:konseling_sessions,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'required|string'
        ]);

        $validated['mahasiswa_id'] = auth()->id();

        Feedback::create($validated);

        return redirect()->route('konseling-mahasiswa.index')
            ->with('success', 'Feedback berhasil diberikan');
    }
}