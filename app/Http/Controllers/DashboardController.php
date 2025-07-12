<?php

namespace App\Http\Controllers;

use App\Models\KonselingSession;
use App\Models\RescheduleHistory;
use App\Models\Feedback;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private function getKonselingStatistics($konselorId) 
    {
        $now = Carbon::now();
        
        // Daily stats for last 7 days
        $daily = KonselingSession::where('konselor_id', $konselorId)
            ->whereBetween('tanggal', [Carbon::now()->subDays(6), Carbon::now()])
            ->selectRaw('DATE(tanggal) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Weekly stats for last 4 weeks
        $weekly = KonselingSession::where('konselor_id', $konselorId)
            ->whereBetween('tanggal', [Carbon::now()->subWeeks(3), Carbon::now()])
            ->selectRaw('YEARWEEK(tanggal) as week, COUNT(*) as count')
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Monthly stats for last 6 months
        $monthly = KonselingSession::where('konselor_id', $konselorId)
            ->whereBetween('tanggal', [Carbon::now()->subMonths(5), Carbon::now()])
            ->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly
        ];
    }

    public function index()
    {   
        if (auth()->user()->isMahasiswa()) {
            $today = Carbon::today();
            
            // Upcoming approved sessions
            $upcomingSessions = KonselingSession::where('mahasiswa_id', auth()->id())
                ->where('tanggal', '>=', $today)
                ->where('status', 'approved')
                ->with(['konselor', 'sesi'])
                ->orderBy('tanggal')
                ->get();
    
            // Recent updates (current month and not passed date)
            $recentUpdates = KonselingSession::where('mahasiswa_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'reschedule', 'canceled'])
            ->whereMonth('tanggal', Carbon::now()->month)
            ->whereYear('tanggal', Carbon::now()->year)
            ->where('tanggal', '>=', $today)
            ->with(['konselor', 'sesi'])
            ->latest('updated_at')
            ->get();
    
            // Reschedule history
            $reschedules = RescheduleHistory::whereHas('konseling', function($q) {
                $q->where('mahasiswa_id', auth()->id());
            })->with(['konseling', 'oldSesi', 'newSesi'])
              ->latest()
              ->get();
    
            // Sessions with konselor notes
            $sessionNotes = KonselingSession::where('mahasiswa_id', auth()->id())
                ->whereNotNull('catatan_konselor')
                ->with(['konselor', 'sesi'])
                ->latest()
                ->get();
    
            return view('dashboard', compact(
                'upcomingSessions',
                'recentUpdates',
                'reschedules',
                'sessionNotes'
            ));
        }

        if (auth()->user()->isKonselor()) {
            $today = Carbon::today();
            $tomorrow = Carbon::tomorrow();
            $twoDaysFromNow = Carbon::today()->addDays(7);
                
            // Add upcoming sessions
            $upcomingSessions = KonselingSession::where('konselor_id', auth()->id())
                ->whereBetween('tanggal', [$tomorrow, $twoDaysFromNow])
                ->where('status', 'approved')
                ->with(['mahasiswa', 'sesi'])
                ->orderBy('tanggal')
                ->orderBy('sesi_id')
                ->get();
                
            $todaySessions = KonselingSession::where('konselor_id', auth()->id())
                ->where('tanggal', $today)
                ->where('status', 'approved')
                ->with(['mahasiswa', 'sesi'])
                ->get();
    
            $pendingSessions = KonselingSession::where('konselor_id', auth()->id())
                ->where('status', 'pending')
                ->with(['mahasiswa', 'sesi'])
                ->get();
    
            $rescheduledSessions = KonselingSession::where('konselor_id', auth()->id())
                ->where('status', 'reschedule')
                ->where('tanggal', '>=', $today)
                ->with(['mahasiswa', 'sesi', 'rescheduleHistory' => function($q) {
                    $q->latest();
                }])
                ->get();
    
            $feedbacks = Feedback::whereHas('session', function($q) {
                $q->where('konselor_id', auth()->id());
            })->with(['mahasiswa', 'session'])->get();
    
            $statistics = $this->getKonselingStatistics(auth()->id());

            return view('dashboard', compact(
                'todaySessions',
                'pendingSessions',
                'rescheduledSessions',
                'feedbacks',
                'statistics',
                'upcomingSessions'
            ));
        }

        return view('dashboard');
    }
}