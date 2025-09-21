@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Yangi savol qo‘shish</h2>
        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="title">Sarlavha</label>
                <input type="text" name="title" class="form-control" required value="{{ old('title') }}">
            </div>

            <div class="mb-3">
                <label for="body">Savol matni</label>
                <textarea name="body" rows="6" class="form-control" required>{{ old('body') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="category_id">Kategoriya</label>
                <select name="category_id" class="form-control">
                    <option value="">— Tanlang —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success">Yuborish</button>
        </form>
    </div>
@endsection

