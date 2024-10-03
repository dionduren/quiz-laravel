@extends('layouts.app')

@section('title', 'Quiz - Session ' . $sessionNumber)

@section('content')
    <div class="container mt-3">

        <!-- Button to Show Question -->
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h3>Soal ke-{{ $currentQuiz->question_number }}</h3>
                <h2>{{ $currentQuiz->category }}</h2>
            </div>

            <div class="col-md-6">
                <button id="showQuestionButton" class="btn btn-primary w-100">Show Question</button>
            </div>
        </div>

        <!-- Display Current Question -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8 text-center">
                <div id="question-container" class="text-center" style="display: none;">
                    <h1 id="questionText" class="typing-text"></h1>
                </div>

                <!-- Display Image if Available -->
                @if ($currentQuiz->image)
                    <img id="questionImage" src="{{ asset('storage/' . $currentQuiz->image) }}" class="img-fluid mb-3"
                        style="display:none;" alt="Question Image">
                @endif

                <!-- Display Audio if Available -->
                @if ($currentQuiz->audio)
                    <audio id="questionAudio" controls class="mb-3 w-100" style="display:none;">
                        <source src="{{ asset('storage/' . $currentQuiz->audio) }}" type="audio/mpeg">
                        Your browser does not support the audio element.
                    </audio>
                @endif
            </div>
        </div>

        <!-- Lyrics Section (for JSON Lyrics) -->
        @if ($currentQuiz->lyrics_json)
            <div class="row justify-content-center mt-4">
                <div class="col-md-8 text-center">
                    <h3>Lyrics</h3>
                    <div id="lyrics-container" class="p-3 border border-dark rounded mt-3 mb-5"
                        style="font-size: 60px;font-weight: 600;text-transform: uppercase;">
                        <!-- Lyrics will be populated here -->
                    </div>
                </div>
            </div>
        @endif

        <!-- Show Answer -->
        <div class="row justify-content-center mt-5 mb-5">
            <div class="col-md-8">
                <button id="showAnswerButton" class="btn btn-warning w-100" onclick="showAnswer()">Show Answer</button>
                <div class="text-center my-3" id="answer" style="display:none">
                    <h1>{{ $currentQuiz->answer }}</h1>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-4">
                @if ($questionIndex > 0)
                    <a href="{{ route('quiz.session', ['sessionId' => $sessionNumber, 'questionIndex' => $questionIndex - 1]) }}"
                        class="btn btn-secondary w-100">Previous Question</a>
                @endif
            </div>
            <div class="col-md-4">
                @if ($questionIndex < $totalQuestions - 1)
                    <a href="{{ route('quiz.session', ['sessionId' => $sessionNumber, 'questionIndex' => $questionIndex + 1]) }}"
                        class="btn btn-success w-100">Next Question</a>
                @endif
            </div>
        </div>
    </div>
@endsection


@section('footer')
    <!-- Team Scores Section in Footer -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            @foreach ($teams->sortBy('name') as $team)
                <div class="col-md-3 mb-3 text-center">
                    <div class="team-score-card"
                        style="background-color: {{ $team->color }}; color: {{ $team->font_color }}; border: 2px solid black; border-radius: 10px; padding: 20px;">
                        <h4>{{ $team->name }}</h4>
                        <h2 id="team-score-{{ $team->id }}">
                            {{ $team->teamScores->where('session', $sessionNumber)->first()->score ?? 0 }}</h2>

                        <div class="mt-3">
                            <button class="btn btn-light" style="border: 1px solid black; border-radius: 10px;"
                                onclick="adjustScore({{ $team->id }}, 100, {{ $sessionNumber }})">
                                <i class="bi bi-arrow-up-circle-fill" style="color: green"></i>
                            </button>
                            <button class="btn btn-light" style="border: 1px solid black; border-radius: 10px;"
                                onclick="adjustScore({{ $team->id }}, -100, {{ $sessionNumber }})">
                                <i class="bi bi-arrow-down-circle-fill" style="color: red"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle "Show Question" button click
        $('#showQuestionButton').click(function() {
            $(this).hide(); // Hide the button

            // Show the question and images/audio if available
            $('#question-container').fadeIn();
            $('#questionImage').fadeIn();
            $('#questionAudio').fadeIn();

            // Type out the question with animation
            var question = "{{ $currentQuiz->question }}";
            var index = 0;

            function typeNextChar() {
                if (index < question.length) {
                    $('#questionText').append(question.charAt(index));
                    index++;
                    setTimeout(typeNextChar, 50); // Delay between characters
                }
            }
            typeNextChar();

            // Handle Lyrics Display
            @if ($currentQuiz->lyrics_json)
                var lyrics = {!! $currentQuiz->lyrics_json !!}; // Parse the lyrics JSON
                var lyricsIndex = 0;

                function updateLyrics() {
                    var currentTime = $('#questionAudio')[0].currentTime;
                    if (lyricsIndex < lyrics.lyrics.length && currentTime >= lyrics.lyrics[lyricsIndex]
                        .start) {
                        // Highlight the current lyrics
                        $('#lyrics-container').text(lyrics.lyrics[lyricsIndex].text);
                        lyricsIndex++;
                    }
                }

                // Bind lyrics update to audio timeupdate event
                $('#questionAudio').on('timeupdate', updateLyrics);
            @endif
        });
    });

    function showAnswer() {
        document.getElementById('answer').style.display = 'block';
    }

    function adjustScore(teamId, amount, session) {
        fetch(`/teams/${teamId}/score/${session}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    score: amount
                })
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById(`team-score-${teamId}`).innerText = data.newScore;
            });
    }
</script>
