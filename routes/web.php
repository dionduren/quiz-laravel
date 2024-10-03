<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TeamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Main menu
Route::get('/', [QuizController::class, 'index'])->name('main_menu');

// Route to list and edit all quiz questions
Route::get('/quiz', [QuizController::class, 'indexQuizzes'])->name('quiz.index');
Route::get('/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
Route::post('/quiz/store', [QuizController::class, 'store'])->name('quiz.store');
Route::get('/quiz/{id}/edit', [QuizController::class, 'edit'])->name('quiz.edit');
Route::put('/quiz/{id}', [QuizController::class, 'update'])->name('quiz.update');


// Route to show all quizzes for a selected session
Route::get('/quiz/session/{sessionId}/{questionIndex}', [QuizController::class, 'showSession'])->name('quiz.session');
// Route for next and previous questions
Route::get('/quiz/{id}/next', [QuizController::class, 'nextQuestion'])->name('quiz.next');
Route::get('/quiz/{id}/previous', [QuizController::class, 'previousQuestion'])->name('quiz.previous');

// Team management route
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/manage', [TeamController::class, 'manageTeams'])->name('teams.manage');
Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
Route::post('/teams/store', [TeamController::class, 'store'])->name('teams.store');
Route::get('/teams/{id}/edit', [TeamController::class, 'edit'])->name('teams.edit');
Route::put('/teams/{id}', [TeamController::class, 'update'])->name('teams.update');
Route::delete('/teams/{id}', [TeamController::class, 'destroy'])->name('teams.destroy');

Route::post('/teams/{teamId}/score/{session}', [QuizController::class, 'updateScore'])->name('teams.update_score');

Route::get('/scoreboard', [QuizController::class, 'showScoreboard'])->name('teams.scoreboard');
