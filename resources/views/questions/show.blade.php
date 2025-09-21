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
@endsection

