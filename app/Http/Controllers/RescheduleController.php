<?php

namespace App\Http\Controllers;

use App\Models\KonselingSession;
use App\Models\RescheduleHistory;
use App\Models\Session;
use App\Notifications\KonselingRescheduled;
use Illuminate\Http\Request;


class RescheduleController extends Controller
{
    public function create(KonselingSession $konseling)
    {
        if (!auth()->user()->isKonselor() || $konseling->konselor_id !== auth()->id()) {
            abort(403);
        }

        $waktuSesi = Session::all();
        return view('reschedule.create', compact('konseling', 'waktuSesi'));
    }

    public function store(Request $request, KonselingSession $konseling)
    {
        if (!auth()->user()->isKonselor() || $konseling->konselor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'new_tanggal' => 'required|date|after:today',
            'new_sesi_id' => 'required|exists:sesi,id',
        ]);

        // Check if slot is available
        $existingBooking = KonselingSession::where('konselor_id', $konseling->konselor_id)
        ->where('tanggal', $validated['new_tanggal'])
        ->where('sesi_id', $validated['new_sesi_id'])
        ->where('id', '!=', $konseling->id) // Exclude current konseling
        ->whereIn('status', ['pending', 'approved', 'reschedule', 'finished'])
        ->exists();

        if ($existingBooking) {
            return back()->withInput()
                ->withErrors(['new_sesi_id' => 'Anda sudah memiliki jadwal lain pada tanggal dan sesi ini.']);
        }

        try {
            \DB::beginTransaction();

            $reschedule = RescheduleHistory::create([
                'konseling_id' => $konseling->id,
                'old_tanggal' => $konseling->tanggal,
                'old_sesi_id' => $konseling->sesi_id,
                'new_tanggal' => $validated['new_tanggal'],
                'new_sesi_id' => $validated['new_sesi_id'],
                'status' => 'pending'
            ]);

            $konseling->update(['status' => 'reschedule']);
            
            // Send notification to mahasiswa
            $konseling->mahasiswa->notify(new KonselingRescheduled($konseling, $reschedule));

            \DB::commit();

            return redirect()->route('konseling-konselor.index')
                ->with('success', 'Pengajuan reschedule berhasil dibuat.');

        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mengajukan reschedule.']);
        }
    }

    public function checkRescheduleSlots(Request $request)
    {
        $request->validate([
            'konselor_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'current_konseling_id' => 'required|exists:konseling_sessions,id'
        ]);
    
        $konselorId = $request->konselor_id;
        $tanggal = $request->tanggal;
        $currentKonselingId = $request->current_konseling_id;
        $currentTime = now();
        $today = $currentTime->format('Y-m-d');
        $currentHourMinute = $currentTime->format('H:i:s');
    
        // Get all sessions
        $allSessions = Session::orderBy('start_time')->get();
        
        // Get bookings for the selected konselor and date, excluding current konseling
        $bookedSlots = KonselingSession::where('konselor_id', $konselorId)
            ->where('tanggal', $tanggal)
            ->where('id', '!=', $currentKonselingId) // Exclude current konseling
            ->whereIn('status', ['pending', 'approved', 'reschedule', 'finished'])
            ->pluck('sesi_id')
            ->toArray();
        
        // Filter available sessions
        $availableSessions = $allSessions->filter(function($session) use ($tanggal, $today, $currentHourMinute, $bookedSlots) {
            // If session already booked, exclude it
            if (in_array($session->id, $bookedSlots)) {
                return false;
            }
            
            // If today, only include sessions that haven't started yet
            if ($tanggal == $today && $session->start_time <= $currentHourMinute) {
                return false;
            }
            
            return true;
        })->values();
        
        return response()->json($availableSessions);
    }
    
}