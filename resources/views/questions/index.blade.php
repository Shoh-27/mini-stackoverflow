@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Savollar ro‘yxati</h1>
        @auth
            <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Savol qo‘shish</a>
        @endauth

        @foreach($questions as $q)
            <div class="card mb-3">
                <div class="card-body">
                    <h5><a href="{{ route('questions.show',$q) }}">{{ $q->title }}</a></h5>
                    <p>{{ Str::limit($q->body, 150) }}</p>
                    <small>
                        by {{ $q->user->name }} |
                        {{ $q->category?->name ?? 'Kategoriya yo‘q' }} |
                        {{ $q->views }} ta ko‘rildi
                    </small>
                </div>
            </div>
        @endforeach

        {{ $questions->links() }}
    </div>
@endsection

