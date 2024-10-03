@extends('layouts.app')

@section('title', 'Edit Quiz Question')

@section('content')
    <div class="container mt-5">
        <h1>Edit Quiz Question</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form to edit an existing quiz question -->
        <form action="{{ route('quiz.update', $quiz->id) }}" method="POST" enctype="multipart/form-data" id="quizForm">
            @csrf
            @method('PUT')

            <!-- Session Selection -->
            <div class="mb-3">
                <label for="session" class="form-label">Session</label>
                <select name="session" id="session" class="form-select" required>
                    <option value="1" {{ $quiz->session == 1 ? 'selected' : '' }}>Session 1</option>
                    <option value="2" {{ $quiz->session == 2 ? 'selected' : '' }}>Session 2</option>
                    <option value="3" {{ $quiz->session == 3 ? 'selected' : '' }}>Session 3</option>
                    <option value="4" {{ $quiz->session == 4 ? 'selected' : '' }}>Session 4</option>
                    <option value="5" {{ $quiz->session == 5 ? 'selected' : '' }}>Session 5</option>
                    <option value="6" {{ $quiz->session == 6 ? 'selected' : '' }}>Session 6</option>
                </select>
            </div>

            <!-- Category Selection -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="general knowledge" {{ $quiz->category == 'general knowledge' ? 'selected' : '' }}>General
                        Knowledge</option>
                    <option value="guess the picture" {{ $quiz->category == 'guess the picture' ? 'selected' : '' }}>Guess
                        the Picture</option>
                    <option value="quick counting" {{ $quiz->category == 'quick counting' ? 'selected' : '' }}>Quick
                        Counting</option>
                    <option value="guess the word" {{ $quiz->category == 'guess the word' ? 'selected' : '' }}>Guess the
                        Word</option>
                    <option value="guess the song name" {{ $quiz->category == 'guess the song name' ? 'selected' : '' }}>
                        Guess the Song Name</option>
                    <option value="guess the lyric" {{ $quiz->category == 'guess the lyric' ? 'selected' : '' }}>Guess the
                        Lyric</option>
                </select>
            </div>

            <!-- Question Number -->
            <div class="mb-3">
                <label for="question_number" class="form-label">Question Number</label>
                <input type="number" name="question_number" class="form-control"
                    value="{{ old('question_number', $quiz->question_number) }}" required>
                @error('question_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Question Input -->
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <input type="text" name="question" id="question" class="form-control" value="{{ $quiz->question }}"
                    required>
            </div>

            <!-- Answer Input -->
            <div class="mb-3">
                <label for="answer" class="form-label">Answer</label>
                <input type="text" name="answer" id="answer" class="form-control" value="{{ $quiz->answer }}"
                    required>
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image (Optional)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                @if ($quiz->image)
                    <img src="{{ asset('storage/' . $quiz->image) }}" alt="Current Image" class="img-fluid mt-3">
                @endif
            </div>

            <!-- Audio Upload -->
            <div class="mb-3">
                <label for="audio" class="form-label">Upload Audio (Optional)</label>
                <input type="file" name="audio" id="audio" class="form-control" accept="audio/*">
                @if ($quiz->audio)
                    <audio controls class="mt-3">
                        <source src="{{ asset('storage/' . $quiz->audio) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                @endif
            </div>


            <!-- Lyrics JSON Input -->
            <div class="mb-3">
                <label for="lyrics_json" class="form-label">Lyrics (Optional, JSON format)</label>
                <textarea name="lyrics_json" id="lyrics_json" class="form-control" rows="5">{{ old('lyrics_json', $quiz->lyrics_json) }}</textarea>
                <small class="form-text text-muted">Enter the lyrics in JSON format with timestamps.</small>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update Question</button>
        </form>
    </div>
@endsection
