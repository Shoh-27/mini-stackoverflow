@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $question->title }}</h2>
        <p>{!! nl2br(e($question->body)) !!}</p>
        <p>
            <small>
                {{ $question->user->name }} tomonidan |
                {{ $question->category?->name ?? 'Kategoriya yo‘q' }} |
                {{ $question->views }} ta ko‘rildi
            </small>
        </p>
    </div>

    <h2>Javoblar</h2>

    @foreach($question->answers()->with('user','votes')->get()->sortByDesc(function($a){
    return ($a->is_best ? 1000 : 0) + $a->vote_count; // best javob tepada
}) as $answer)
        <div class="card mb-2 @if($answer->is_best) border-success @endif">
            <div class="card-body">
                <p>{{ $answer->body }}</p>
                <small>By {{ $answer->user->name }} | {{ $answer->created_at->diffForHumans() }}</small>

                <div class="mt-2">
                    <form action="{{ route('answers.vote', $answer) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="vote" value="1">
                        <button class="btn btn-sm btn-success">👍 {{ $answer->vote_count }}</button>
                    </form>

                    <form action="{{ route('answers.vote', $answer) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="vote" value="-1">
                        <button class="btn btn-sm btn-danger">👎</button>
                    </form>

                    @if(auth()->id() === $question->user_id && !$answer->is_best)
                        <form action="{{ route('answers.best', $answer) }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-sm btn-outline-success">Mark as Best</button>
                        </form>
                    @endif

                    @if($answer->is_best)
                        <span class="badge bg-success">Best Answer</span>
                    @endif
                </div>
            </div>
        </div>
    @endforeach


    @auth
        <form action="{{ route('answers.store', $question) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="body">Sizning javobingiz:</label>
                <textarea name="body" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Javob yuborish</button>
        </form>
    @else
        <p>Javob yozish uchun <a href="{{ route('login') }}">kiring</a>.</p>
    @endauth

@endsection

