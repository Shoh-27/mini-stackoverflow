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
    return ($a->is_best ? 1000 : 0) + $a->vote_count;
}) as $answer)
        <div class="card mb-2 answer" id="answer-{{ $answer->id }}">
            <div class="card-body">
                <p>{{ $answer->body }}</p>
                <small>By {{ $answer->user->name }} | {{ $answer->created_at->diffForHumans() }}</small>

                <div class="mt-2">
                    <button class="btn btn-sm btn-success vote-btn" data-id="{{ $answer->id }}" data-vote="1">
                        👍 <span class="vote-count">{{ $answer->vote_count }}</span>
                    </button>

                    <button class="btn btn-sm btn-danger vote-btn" data-id="{{ $answer->id }}" data-vote="-1">
                        👎
                    </button>

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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Upvote / Downvote
        $('.vote-btn').click(function(e){
            e.preventDefault();
            var answerId = $(this).data('id');
            var vote = $(this).data('vote');
            var button = $(this);

            $.ajax({
                url: '/answers/' + answerId + '/vote',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    vote: vote
                },
                success: function(res){
                    // Vote count yangilash
                    var count = button.closest('.card-body').find('.vote-count');
                    count.text(res.vote_count);
                }
            });
        });

        // Real-time javob qo‘shish
        $('#answer-form').submit(function(e){
            e.preventDefault();
            var form = $(this);
            var body = $('#body').val();

            $.ajax({
                url: '/questions/{{ $question->id }}/answers',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    body: body
                },
                success: function(res){
                    // Javobni sahifaga qo‘shish
                    $('#body').val('');
                    location.reload(); // Oddiy usul, keyin real-time uchun WebSocket ishlatamiz
                }
            });
        });
    });
</script>

