@extends('layouts.app')

@section('title', 'All Quiz Questions')

@section('content')
    <div class="container mt-5">
        <h1>All Quiz Questions</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Session</th>
                    <th>No.</th>
                    <th>Category</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($quizzes as $quiz)
                    <tr>
                        <td>{{ $quiz->session }}</td>
                        <td>{{ $quiz->question_number }}</td>
                        <td>{{ $quiz->category }}</td>
                        <td>{{ $quiz->question }}</td>
                        <td>{{ $quiz->answer }}</td>
                        <td>
                            <a href="{{ route('quiz.edit', $quiz->id) }}" class="btn btn-warning">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
