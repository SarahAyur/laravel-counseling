<?php

// filepath: /d:/projectBackend/laravel-counseling/app/Http/Controllers/Chat/CustomMessagesController.php
namespace App\Http\Controllers\Chat;

use Chatify\Http\Controllers\MessagesController;
use App\Models\KonselingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomMessagesController extends MessagesController
{
    /**
     * Override method index untuk menambahkan validasi chat_enabled
     */
    public function index($id = null)
    {
        // Jika ada ID user yang valid, lakukan validasi
        if ($id !== null && is_numeric($id)) {
            $isEnabled = $this->isChatEnabled($id);
            
            if (!$isEnabled) {
                return redirect()->route('dashboard')->with('error', 'Fitur chat tidak diaktifkan atau tidak tersedia untuk sesi konseling ini.');
            }
        }
        
        // Panggil method asli dari parent class
        return parent::index($id);
    }
    
    /**
     * Cek apakah chat diaktifkan untuk sesi konseling
     */
    private function isChatEnabled($userId)
    {
        $user = Auth::user();
        
        if ($user->role === 'mahasiswa') {
            // Cek apakah ada sesi konseling dengan konselor ini yang chat_enabled = true
            return KonselingSession::where('mahasiswa_id', $user->id)
                ->where('konselor_id', $userId)
                ->where('status', 'approved')
                ->where('chat_enabled', true)
                ->exists();
        } 
        elseif ($user->role === 'konselor') {
            // Cek apakah ada sesi konseling dengan mahasiswa ini yang chat_enabled = true
            return KonselingSession::where('konselor_id', $user->id)
                ->where('mahasiswa_id', $userId)
                ->where('status', 'approved')
                ->where('chat_enabled', true)
                ->exists();
        }
        
        return false;
    }

        public function checkChatStatus(Request $request)
    {
        $userId = $request->id;
        
        if (!$userId || !is_numeric($userId)) {
            return response()->json(['chat_enabled' => false]);
        }
        
        $isEnabled = $this->isChatEnabled($userId);
        
        return response()->json([
            'chat_enabled' => $isEnabled
        ]);
    }
}