<?php

namespace App\Http\Controllers;

use App\Models\KonselingSession;
use App\Models\Session;
use App\Models\User;
use App\Models\RescheduleHistory;
use Illuminate\Http\Request;
use App\Notifications\KonselingRequested;
use App\Notifications\RescheduleResponsed;
use App\Models\FormAnswer;
use App\Models\FormQuestion;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class KonselingMahasiswaController extends Controller
{
    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'mahasiswa') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function index()
    {
        if (!auth()->user()->isMahasiswa()) {
            abort(403);
        }
        $sessions = KonselingSession::where('mahasiswa_id', auth()->id())
            ->with(['konselor', 'session', 'sesi'])
            ->latest()
            ->get();
        return view('konseling-mahasiswa.index', compact('sessions'));
    }

    public function create()
    {
        $konselors = User::where('role', 'konselor')
                        ->where('is_active', true)
                        ->get();
        $waktuSesi = Session::all();
        $questions = FormQuestion::orderBy('urutan')->get();
        
        return view('konseling-mahasiswa.create', compact('konselors', 'waktuSesi', 'questions'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'konselor_id' => 'required|exists:users,id',
            'tanggal' => 'required|date|after_or_equal:today',
            'sesi_id' => 'required|exists:sesi,id',
            'topik' => 'required|string|max:255',
            'answers' => 'required|array',
            'answers.*.jawaban' => 'required|string',
        ]);
    
        $existingBooking = KonselingSession::where('konselor_id', $request->konselor_id)
            ->where('tanggal', $request->tanggal)
            ->where('sesi_id', $request->sesi_id)
            ->whereIn('status', ['pending', 'approved', 'reschedule', 'finished'])
            ->exists();
    
        if ($existingBooking) {
            return back()->withInput()
                ->withErrors(['sesi_id' => 'Konselor sudah memiliki jadwal pada tanggal dan sesi ini.']);
        }
    
        try {
            \DB::beginTransaction();
            
            // Create konseling session
            $konseling = KonselingSession::create([
                'mahasiswa_id' => auth()->id(),
                'konselor_id' => $validated['konselor_id'],
                'tanggal' => $validated['tanggal'],
                'sesi_id' => $validated['sesi_id'],
                'topik' => $validated['topik'],
                'status' => 'pending'
            ]);
            
            // Save form answers
            foreach ($validated['answers'] as $questionId => $answer) {
                FormAnswer::create([
                    'sesi_id' => $konseling->id,
                    'mahasiswa_id' => auth()->id(),
                    'question_id' => $questionId,
                    'jawaban' => $answer['jawaban'],
                ]);
            }
            
            \DB::commit();
            
            // Handle notifications
            try {
                $konselor = User::find($request->konselor_id);
                if ($konselor) {
                    $konselor->notify((new KonselingRequested($konseling))->delay(now()->addSeconds(5)));
                }
                auth()->user()->notify((new KonselingRequested($konseling))->delay(now()->addSeconds(10)));
            } catch (\Exception $e) {
                \Log::error('Gagal mengirim notifikasi', ['message' => $e->getMessage()]);
            }
            
            return redirect()->route('konseling-mahasiswa.index')
                ->with('success', 'Pengajuan konseling berhasil dibuat.');
                
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error creating konseling', ['message' => $e->getMessage()]);
            return back()->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    
        public function show($id)
    {
        $konseling = KonselingSession::with(['konselor', 'sesi'])
            ->where('id', $id)
            ->where('mahasiswa_id', auth()->id())
            ->firstOrFail();
    
        $answers = \App\Models\FormAnswer::where('sesi_id', $konseling->id)
            ->where('mahasiswa_id', auth()->id())
            ->with('question')
            ->get();
            
        $rescheduleHistory = RescheduleHistory::where('konseling_id', $konseling->id)
            ->whereIn('status', ['approved', 'canceled'])
            ->with(['oldSesi', 'newSesi']) // Asumsi Anda memiliki relasi ini
            ->orderBy('created_at', 'desc')
            ->get();
    
        return view('konseling-mahasiswa.show', compact('konseling', 'answers', 'rescheduleHistory'));
    }
   
    
    public function updateReschedule(Request $request, KonselingSession $konseling)
    {
        if (!auth()->user()->isMahasiswa() || $konseling->mahasiswa_id !== auth()->id()) {
            abort(403);
        }
    
        $validated = $request->validate([
            'action' => 'required|in:approved,canceled'
        ]);
    
        $reschedule = RescheduleHistory::where('konseling_id', $konseling->id)
            ->where('status', 'pending')
            ->latest()
            ->firstOrFail();
    
        if ($validated['action'] === 'approved') {
            $konseling->update([
                'tanggal' => $reschedule->new_tanggal,
                'sesi_id' => $reschedule->new_sesi_id,
                'status' => 'approved'
            ]);
            $reschedule->update(['status' => 'approved']);
        } else {
            $konseling->update(['status' => 'canceled']); // back to previous status
            $reschedule->update(['status' => 'canceled']);
        }
    
        // Send notification to konselor
        $konseling->konselor->notify(new RescheduleResponsed($konseling, $reschedule, $validated['action']));
    
        return redirect()->route('konseling-mahasiswa.index')
            ->with('success', 'Reschedule konseling berhasil ' . ($validated['action'] === 'approved' ? 'disetujui' : 'ditolak'));
    }

    public function edit(KonselingSession $konseling)
    {
        if (!auth()->user()->isMahasiswa()) {
            abort(403, 'Not a mahasiswa');
        }

        if ($konseling->mahasiswa_id != auth()->id()) {
            abort(403, 'Not authorized for this konseling');
        }
        
        $konselors = User::where('role', 'konselor')->get();
        $waktuSesi = Session::all();
        return view('konseling-mahasiswa.edit', compact('konseling', 'konselors', 'waktuSesi'));
    }

    public function checkSlots(Request $request)
    {
        $request->validate([
            'konselor_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
        ]);

        $konselorId = $request->konselor_id;
        $tanggal = $request->tanggal;
        
        // Gunakan timezone yang benar
        $currentTime = Carbon::now(config('app.timezone'));
        $today = $currentTime->format('Y-m-d');
        $currentHourMinute = $currentTime->format('H:i:s');

        // Get all sessions
        $allSessions = Session::orderBy('start_time')->get();
        
        // Get bookings for the selected konselor and date
        $bookedSlots = KonselingSession::where('konselor_id', $konselorId)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['pending', 'approved', 'reschedule', 'finished'])
            ->pluck('sesi_id')
            ->toArray();
        
        // Debug dengan modifikasi untuk melihat status tiap sesi
        $sessionsWithDebug = $allSessions->map(function($session) use ($tanggal, $today, $currentHourMinute, $bookedSlots) {
            $isBooked = in_array($session->id, $bookedSlots);
            $isToday = $tanggal == $today;
            
            $sessionStartTime = Carbon::createFromFormat('H:i:s', $session->start_time);
            $currentTime = Carbon::createFromFormat('H:i:s', $currentHourMinute);
            $isPastTime = false;
            
            if ($isToday) {
                $isPastTime = $sessionStartTime->lessThanOrEqualTo($currentTime);
            }
            
            $isAvailable = !$isBooked && !($isToday && $isPastTime);
            
            return [
                'id' => $session->id,
                'name' => $session->name,
                'start_time' => $session->start_time,
                'end_time' => $session->end_time,
                'is_available' => $isAvailable,
                'debug' => [
                    'is_booked' => $isBooked,
                    'is_today' => $isToday,
                    'session_start' => $sessionStartTime->format('H:i:s'),
                    'current_time' => $currentTime->format('H:i:s'),
                    'is_past_time' => $isPastTime,
                    'comparison_result' => $sessionStartTime->lessThanOrEqualTo($currentTime) ? 'less/equal' : 'greater'
                ]
            ];
        });
        
        // Filter available sessions
        $availableSessions = $sessionsWithDebug->filter(function($session) {
            return $session['is_available'];
        })->values();
        
        // Log hasil untuk debugging
        // \Log::debug('Available Sessions Result', ['sessions' => $availableSessions]);
        
        return response()->json($availableSessions);
    }
}