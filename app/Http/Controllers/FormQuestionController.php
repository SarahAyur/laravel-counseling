<?php

namespace App\Http\Controllers;

use App\Models\FormQuestion;
use Illuminate\Http\Request;

class FormQuestionController extends Controller
{
    public function index()
    {
        $questions = FormQuestion::orderBy('urutan')->get();
        return view('form-questions.index', compact('questions'));
    }

    public function create()
    {
        // Dapatkan urutan terakhir + 1
        $nextOrder = FormQuestion::max('urutan') + 1;
        return view('form-questions.create', compact('nextOrder'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'tipe' => 'required|in:text,textarea,select,radio,checkbox',
            'opsi' => 'nullable|required_if:tipe,select,radio,checkbox',
            'urutan' => 'required|integer|min:1'
        ]);
    
        FormQuestion::create($request->all());
        return redirect()->route('form-questions.index')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(FormQuestion $formQuestion)
    {
        return view('form-questions.edit', compact('formQuestion'));
    }

    public function update(Request $request, FormQuestion $formQuestion)
    {
        $request->validate([
            'pertanyaan' => 'required',
            'tipe' => 'required|in:text,textarea,select,radio,checkbox',
            'opsi' => 'nullable|required_if:tipe,select,radio,checkbox',
            'urutan' => 'required|integer|min:1'
        ]);

        $formQuestion->update($request->all());
        return redirect()->route('form-questions.index')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function destroy(FormQuestion $formQuestion)
    {
        $formQuestion->delete();
        return redirect()->route('form-questions.index')->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function __construct()
    {
        if (auth()->user() && auth()->user()->role !== 'konselor') {
            abort(403, 'Unauthorized action.');
        }
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'questions' => 'required|array',
            'questions.*' => 'integer|exists:form_questions,id'
        ]);
    
        $questions = $request->questions;
        
        foreach ($questions as $index => $questionId) {
            FormQuestion::where('id', $questionId)->update(['urutan' => $index + 1]);
        }
        
        return response()->json(['success' => true]);
    }
}