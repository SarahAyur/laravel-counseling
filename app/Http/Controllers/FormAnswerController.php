<?php

namespace App\Http\Controllers;

use App\Models\FormAnswer;
use App\Models\FormQuestion;
use App\Models\KonselingSession;
use Illuminate\Http\Request;
use App\Filament\User\Resources\KonselingSessionResource;

class FormAnswerController extends Controller
{
    public function create(Request $request)
    {
        $sesiId = $request->query('sesi_id');
        $session = KonselingSession::findOrFail($sesiId);
        $questions = FormQuestion::orderBy('urutan')->get();

        return view('form-answers.create', compact('session', 'questions'));
    }

        public function store(Request $request)
    {
        $data = $request->validate([
            'sesi_id' => 'required|exists:konseling_sessions,id',
            'answers' => 'required|array',
            'answers.*.jawaban' => 'required|string',
        ]);
    
        foreach ($data['answers'] as $questionId => $answer) {
            FormAnswer::create([
                'sesi_id' => $data['sesi_id'],
                'mahasiswa_id' => auth()->id(),
                'question_id' => $questionId,
                'jawaban' => $answer['jawaban'],
            ]);
        }
    
        return redirect()->route('konseling-mahasiswa.show', $data['sesi_id'])
            ->with('success', 'Form pertanyaan berhasil diisi.');
    }
}