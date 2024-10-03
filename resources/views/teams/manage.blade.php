@extends('layouts.app')

@section('title', 'Team Management')

@section('content')
    <div class="container mt-5">
        <h1>Team Management</h1>

        <!-- Create Team Button -->
        <a href="{{ route('teams.create') }}" class="btn btn-primary mb-3">Create New Team</a>

        <table class="table">
            <thead>
                <tr>
                    <th>Team Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td style="background-color: {{ $team->color }}; color: {{ $team->font_color }};">
                            {{ $team->name }}</td>
                        <td>
                            <a href="{{ route('teams.edit', $team->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('teams.destroy', $team->id) }}" method="POST"
                                style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>
@endsection
