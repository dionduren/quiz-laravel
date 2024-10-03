@extends('layouts.app')

@section('title', 'Create Team')

@section('content')
    <div class="container mt-5">
        <h1>Create New Team</h1>
        <form action="{{ route('teams.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Team Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Team Color</label>
                <input type="color" name="color" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="font_color" class="form-label">Font Color</label>
                <input type="color" name="font_color" class="form-control" value="#ffffff" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Team</button>
        </form>
    </div>
@endsection
