@extends('layouts.app')

@section('title', 'Scoreboard')

@section('content')

    @php
        $teams = $teams
            ->map(function ($team) use ($sessions) {
                $totalScore = 0;
                foreach ($sessions as $session) {
                    $score = $team->teamScores->where('session', $session)->first()->score ?? 0;
                    $totalScore += $score;
                }
                $team->totalScore = $totalScore;
                return $team;
            })
            ->sortByDesc('totalScore');
    @endphp

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
                        <td style="background-color: {{ $team->color }}; color: {{ $team->font_color }};">
                            {{ $team->name }}
                        </td>
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
