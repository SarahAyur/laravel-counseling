<?php

namespace App\Http\Controllers;

use App\Models\KonselingSession;
use App\Models\FormAnswer;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\RescheduleHistory;

class KonselingHistoryController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isKonselor()) {
            abort(403);
        }

        $sessions = KonselingSession::where('konselor_id', auth()->id())
            ->whereIn('status', ['canceled', 'finished'])
            ->with(['mahasiswa', 'sesi'])
            ->latest()
            ->get();

        return view('konseling-history.index', compact('sessions'));
    }

    public function show($id)
    {
        $session = KonselingSession::with(['mahasiswa', 'sesi'])
            ->where('id', $id)
            ->where('konselor_id', auth()->id())
            ->firstOrFail();

        $answers = FormAnswer::where('sesi_id', $session->id)
            ->with('question')
            ->get();

        $feedback = Feedback::where('sesi_id', $session->id)->first();

        $rescheduleHistory = RescheduleHistory::where('konseling_id', $session->id)
        ->whereIn('status', ['approved', 'canceled'])
            ->with(['oldSesi', 'newSesi']) // Asumsi Anda memiliki relasi ini
            ->orderBy('created_at', 'desc')
            ->get();

        return view('konseling-history.show', compact('session', 'answers', 'feedback', 'rescheduleHistory'));
    }

    public function update(Request $request, KonselingSession $konseling)
    {
        if (!auth()->user()->isKonselor() || $konseling->konselor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'catatan_konselor' => 'required|string',
        ]);

        $konseling->update($validated);
        return redirect()->route('konseling-history.index')
            ->with('success', 'Catatan konseling berhasil diperbarui.');
    }
}