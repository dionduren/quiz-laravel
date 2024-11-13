@extends('layouts.app')

@section('title', 'Create Quiz Question')

@section('content')
    <div class="container mt-5">
        <h1>Create Quiz Question</h1>

        <!-- Success Message (will be shown after successful AJAX request) -->
        <div id="success-message" class="alert alert-success" style="display:none;"></div>

        <!-- Error Messages (will be dynamically populated) -->
        <div id="error-messages" class="alert alert-danger" style="display:none;"></div>

        <!-- Form to create a new quiz question -->
        <form id="create-quiz-form" action="{{ route('quiz.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Session Selection -->
            <div class="mb-3">
                <label for="session" class="form-label">Session</label>
                <select name="session" id="session" class="form-select" required>
                    <option value="1">Session 1</option>
                    <option value="2">Session 2</option>
                    <option value="3">Session 3</option>
                    <option value="4">Session 4</option>
                    <option value="5">Session 5</option>
                    <option value="6">Session 6</option>
                    <option value="7">Session Training</option>
                </select>
            </div>

            <!-- Category Selection -->
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="Pengetahuan Umum">Pengetahuan Umum</option>
                    <option value="Tebak Gambar">Tebak Gambar</option>
                    <option value="Mencongak">Mencongak</option>
                    <option value="TTS Cak Montong">TTS Cak Montong</option>
                    <option value="Tebak Judul">Tebak Judul</option>
                    <option value="Sambung Lirik">Sambung Lirik</option>
                </select>
            </div>

            <!-- Question Number -->
            <div class="mb-3">
                <label for="question_number" class="form-label">Question Number</label>
                <input type="number" name="question_number" class="form-control" id="question_number" required>
            </div>

            <!-- Question Input -->
            <div class="mb-3">
                <label for="question" class="form-label">Question</label>
                <textarea name="question" id="question" class="form-control" rows="5" required>{{ old('question') }}</textarea>
            </div>

            <!-- Answer Input -->
            <div class="mb-3">
                <label for="answer" class="form-label">Answer</label>
                <input type="text" name="answer" id="answer" class="form-control" required>
            </div>

            <!-- Image Upload -->
            <div class="mb-3">
                <label for="image" class="form-label">Upload Image (Optional)</label>
                <input type="file" name="image" id="image" class="form-control" accept="image/*">
            </div>

            <!-- Audio Upload -->
            <div class="mb-3">
                <label for="audio" class="form-label">Upload Audio (Optional)</label>
                <input type="file" name="audio" id="audio" class="form-control" accept="audio/*">
            </div>

            <!-- Lyrics JSON Input -->
            <div class="mb-3">
                <label for="lyrics_json" class="form-label">Lyrics (Optional, JSON format)</label>
                <textarea name="lyrics_json" id="lyrics_json" class="form-control" rows="5"></textarea>
                <small class="form-text text-muted">Enter the lyrics in JSON format with timestamps.</small>
            </div>

            <div class="mb-3">
                <label for="answer_audio" class="form-label">Upload Answer Audio (Optional)</label>
                <input type="file" name="answer_audio" id="answer_audio" class="form-control" accept="audio/*">
            </div>


            <!-- Submit Button -->
            <button type="submit" id="submit-button" class="btn btn-primary">Create Question</button>
        </form>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            // Handle form submission
            $('#create-quiz-form').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                // Clear previous errors
                $('#error-messages').hide().html('');
                $('#success-message').hide().html('');

                var formData = new FormData(this);

                $.ajax({
                    url: "{{ route('quiz.store') }}", // Adjust URL to your route
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response.message); // Show success message
                        window.location.href = response
                            .redirect_url; // Redirect to the main menu
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = '';

                        $.each(errors, function(key, value) {
                            errorMessages += '<p>' + value[0] + '</p>';
                        });

                        $('#error-messages').html(errorMessages).fadeIn();
                    }
                });
            });
        });
    </script>
@endsection
