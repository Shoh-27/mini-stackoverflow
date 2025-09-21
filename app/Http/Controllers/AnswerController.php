<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function store(Request $request, Question $question)
    {
        $request->validate([
            'body' => 'required|string|min:5',
        ]);

        $question->answers()->create([
            'body' => $request->body,
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Javob muvaffaqiyatli qo‘shildi!');
    }
}

