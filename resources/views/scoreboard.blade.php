@extends('layouts.app')

@section('title', 'Scoreboard')

@section('content')
    <div class="container mt-5">
        <h1>Scoreboard</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Team Name</th>
                    @foreach ($sessions as $session)
                        <th>Session {{ $session }}</th>
                    @endforeach
                    <th>Total Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{ $team->name }}</td>
                        @php
                            $totalScore = 0;
                        @endphp
                        @foreach ($sessions as $session)
                            @php
                                $score = $team->teamScores->where('session', $session)->first()->score ?? 0;
                                $totalScore += $score;
                            @endphp
                            <td>{{ $score }}</td>
                        @endforeach
                        <td>{{ $totalScore }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
