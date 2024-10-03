@extends('layouts.app')

@section('title', 'Team Scoreboard')

@section('content')
    <div class="container mt-5">
        <h1>Team Scoreboard</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-striped">
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
                        <td>{{ $team->score }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
