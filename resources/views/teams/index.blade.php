@extends('layouts.app')

@section('title', 'Teams')

@section('content')
    <div class="container mt-5">
        <h1>Teams and Scores</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Team Name</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $team->name }}</td>
                        <td>{{ $team->teamScores->sum('score') ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
