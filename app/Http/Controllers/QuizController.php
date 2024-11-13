<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Team;
use App\Models\TeamScore;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Display the main menu where categories/sessions can be selected
    public function index()
    {
        // This could be customized to show different sessions or categories
        return view('main_menu');
    }

    public function showSession($sessionId, $questionIndex = 0)
    {
        $quizzes = Quiz::where('session', $sessionId)->orderBy('question_number')->get();
        $teams = Team::all();  // Fetch all teams
        $totalQuestions = $quizzes->count();

        if ($totalQuestions == 0) {
            return redirect()->route('main_menu')->with('error', 'No questions in this session.');
        }

        // Get the current quiz question based on the index
        if ($questionIndex >= $totalQuestions) {
            return redirect()->route('main_menu')->with('error', 'No more questions.');
        }

        $currentQuiz = $quizzes->get($questionIndex);  // Fetch quiz by index in session

        return view('quiz_session', [
            'quizzes' => $quizzes,
            'currentQuiz' => $currentQuiz,
            'sessionNumber' => $sessionId,
            'questionIndex' => $questionIndex,
            'totalQuestions' => $totalQuestions,
            'teams' => $teams
        ]);
    }

    public function showScoreboard()
    {
        $teams = Team::with('teamScores')->get();
        $sessions = Quiz::distinct('session')->pluck('session'); // Get all session numbers

        return view('scoreboard', [
            'teams' => $teams,
            'sessions' => $sessions
        ]);
    }

    // Adjust score for a team
    public function updateScore(Request $request, $teamId, $session)
    {
        $teamScore = TeamScore::firstOrCreate(
            ['team_id' => $teamId, 'session' => $session],
            ['score' => 0]
        );

        // Update the score
        $teamScore->score += $request->input('score');
        $teamScore->save();

        return response()->json(['newScore' => $teamScore->score]);
    }


    // Move to the next question in the session
    public function nextQuestion($currentQuizId)
    {
        $currentQuiz = Quiz::findOrFail($currentQuizId);
        $nextQuiz = Quiz::where('session', $currentQuiz->session)
            ->where('id', '>', $currentQuiz->id)
            ->orderBy('id')
            ->first();

        if ($nextQuiz) {
            return redirect()->route('quiz.show.id', ['id' => $nextQuiz->id]);
        }

        // If no next quiz, stay on the current one (or redirect to the first question of the session)
        return redirect()->route('quiz.show.id', ['id' => $currentQuizId]);
    }

    // Move to the previous question in the session
    public function previousQuestion($currentQuizId)
    {
        $currentQuiz = Quiz::findOrFail($currentQuizId);
        $previousQuiz = Quiz::where('session', $currentQuiz->session)
            ->where('id', '<', $currentQuiz->id)
            ->orderBy('id', 'desc')
            ->first();

        if ($previousQuiz) {
            return redirect()->route('quiz.show.id', ['id' => $previousQuiz->id]);
        }

        // If no previous quiz, stay on the current one (or redirect to the first question)
        return redirect()->route('quiz.show.id', ['id' => $currentQuizId]);
    }

    // Show the form for creating a new quiz question
    public function create()
    {
        return view('create_question');
    }

    // Store the new quiz question
    public function store(Request $request)
    {
        $request->validate([
            'session' => 'required|integer',
            'category' => 'required|string',
            'question_number' => 'required|integer|unique:quizzes,question_number,NULL,id,session,' . $request->session,
            'question' => 'required|string',
            'answer' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'nullable|mimes:mp3,wav|max:10000',
            'lyrics_json' => 'nullable|json',
        ]);

        // Check for duplicate question_number in the same session
        $existingQuiz = Quiz::where('session', $request->session)
            ->where('question_number', $request->question_number)
            ->first();

        if ($existingQuiz) {
            return redirect()->back()->withErrors(['question_number' => 'This question number already exists in the selected session.']);
        }

        $quiz = new Quiz();
        $quiz->category = $request->category;
        $quiz->question = $request->question;
        $quiz->answer = $request->answer;
        $quiz->session = $request->session;
        $quiz->question_number = $request->question_number;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $quiz->image = $imagePath;
        }

        // Handle audio upload
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('audio', 'public');
            $quiz->audio = $audioPath;
        }

        if ($request->input('lyrics_json')) {
            $quiz->lyrics_json = $request->input('lyrics_json');
        }

        // Handle answer audio upload
        if ($request->hasFile('answer_audio')) {
            $answerAudioPath = $request->file('answer_audio')->store('audio', 'public');
            $quiz->answer_audio = $answerAudioPath;
        }


        $quiz->save();

        // Return JSON response and redirect to main menu

        return redirect()->route('quiz.create', $quiz->id)->with('success', 'Question updated successfully!');

        // return response()->json([
        //     'message' => 'Question created successfully!',
        //     'redirect_url' => route('main_menu'), // Provide the main menu route URL in the response
        // ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category' => 'required|string',
            'question' => 'required|string',
            'answer' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'audio' => 'nullable|mimes:mp3,wav,m4a|max:10000', // Include m4a in validation
            'lyrics_json' => 'nullable|json',
            'answer_audio' => 'nullable|mimes:mp3,wav,m4a|max:10000',
            'session' => 'required|integer',
            'question_number' => 'required|integer|unique:quizzes,question_number,' . $id . ',id,session,' . $request->session,
        ]);

        $quiz = Quiz::findOrFail($id);
        $quiz->category = $request->category;
        $quiz->question = $request->question;
        $quiz->answer = $request->answer;
        $quiz->session = $request->session;
        $quiz->question_number = $request->question_number;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $quiz->image = $imagePath;
        }

        // Handle audio upload
        if ($request->hasFile('audio')) {
            $audioPath = $request->file('audio')->store('audio', 'public');
            $quiz->audio = $audioPath;
        }

        // Store lyrics if present
        if ($request->input('lyrics_json')) {
            $quiz->lyrics_json = $request->input('lyrics_json');
        }

        // Handle answer audio upload
        if ($request->hasFile('answer_audio')) {
            $answerAudioPath = $request->file('answer_audio')->store('audio', 'public');
            $quiz->answer_audio = $answerAudioPath;
        }


        $quiz->save();

        // return redirect()->route('quiz.edit')->with('success', 'Question updated successfully!');
        return redirect()->route('quiz.edit', $quiz->id)->with('success', 'Question updated successfully!');
    }

    public function indexQuizzes()
    {
        // Retrieve quizzes sorted by session and question number
        $quizzes = Quiz::orderBy('session')->orderBy('question_number')->get();

        // Pass the sorted quizzes to the view
        return view('quizzes.index', compact('quizzes'));
    }

    public function edit($id)
    {
        // Fetch the quiz by ID
        $quiz = Quiz::findOrFail($id);
        return view('quizzes.edit', compact('quiz'));
    }
}
