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

    public function markBest(Answer $answer)
    {
        $question = $answer->question;

        // Faqat savol egasi belgilashi mumkin
        if (auth()->id() !== $question->user_id) {
            abort(403);
        }

        // Avvalgi best answer bo‘lsa uni olib tashlash
        $question->answers()->update(['is_best' => false]);

        // Tanlangan javobni best deb belgilash
        $answer->update(['is_best' => true]);

        return redirect()->back()->with('success', 'Eng yaxshi javob belgilandi!');
    }

}

