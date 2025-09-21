<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    // Savollar ro‘yxati
    public function index()
    {
        $questions = Question::with('user','category')
            ->latest()
            ->paginate(10);

        return view('questions.index', compact('questions'));
    }

    // Bitta savol
    public function show(Question $question)
    {
        $question->increment('views');
        $question->load('user','category');
        return view('questions.show', compact('question'));
    }

    // Savol qo‘shish formasi
    public function create()
    {
        $categories = Category::all();
        return view('questions.create', compact('categories'));
    }

    // Yangi savolni saqlash
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required|max:255',
            'body'=>'required',
            'category_id'=>'nullable|exists:categories,id'
        ]);

        $question = $request->user()->questions()->create($request->only('title','body','category_id'));

        return redirect()->route('questions.show', $question)->with('success','Savol muvaffaqiyatli qo‘shildi!');
    }
}

