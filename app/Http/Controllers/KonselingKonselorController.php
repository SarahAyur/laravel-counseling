<?php

namespace App\Http\Controllers;

use App\Models\KonselingSession;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\KonselingStatusChanged;
use App\Models\RescheduleHistory;

class KonselingKonselorController extends Controller
{
    public function index()
    {
        if (!auth()->user()->isKonselor()) {
            abort(403);
        }

        $sessions = KonselingSession::where('konselor_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'reschedule'])
            ->with(['mahasiswa', 'session'])
            ->latest()
            ->get();
        return view('konseling-konselor.index', compact('sessions'));
    }

public function edit(KonselingSession $konseling)
{
    // \Log::info('User ID: ' . auth()->id());
    // \Log::info('Konseling ID: ' . $konseling->id);
    // \Log::info('Konseling Data: ', $konseling->toArray());

    if (!auth()->user()->isKonselor()) {
        abort(403, 'Not a konselor');
    }

    if ($konseling->konselor_id != auth()->id()) {
        abort(403, 'Not authorized for this konseling');
    }

    return view('konseling-konselor.edit', compact('konseling'));
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
        return redirect()->route('konseling-konselor.index')
            ->with('success', 'Catatan konseling berhasil diperbarui.');
    }

    
    public function updateStatus(Request $request, KonselingSession $konseling)
    {
        if (!auth()->user()->isKonselor() || $konseling->konselor_id !== auth()->id()) {
            abort(403);
        }
    
        $request->validate([
            'status' => 'required|in:approved,canceled,finished'
        ]);
    
        $konseling->update(['status' => $request->status]);
        
        // Send notification to mahasiswa
        $konseling->mahasiswa->notify(new KonselingStatusChanged($konseling, $request->status));
    
        return redirect()->route('konseling-konselor.index')
            ->with('success', 'Status konseling berhasil diperbarui.');
    }

        public function show($id)
    {
        $konseling = KonselingSession::with(['mahasiswa', 'sesi'])
            ->where('id', $id)
            ->where('konselor_id', auth()->id())
            ->firstOrFail();
    
        $answers = \App\Models\FormAnswer::where('sesi_id', $konseling->id)
            ->with('question')
            ->get();
            
        $rescheduleHistory = RescheduleHistory::where('konseling_id', $konseling->id)
            ->whereIn('status', ['approved', 'canceled'])
            ->with(['oldSesi', 'newSesi']) // Asumsi Anda memiliki relasi ini
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('konseling-konselor.show', compact('konseling', 'answers', 'rescheduleHistory'));
    }

    public function toggleChat(KonselingSession $konseling)
    {
        if (!auth()->user()->isKonselor() || $konseling->konselor_id !== auth()->id()) {
            abort(403);
        }

        $konseling->update([
            'chat_enabled' => !$konseling->chat_enabled
        ]);

        return back()->with('success', 'Chat status updated successfully');
    }
}