@extends('layouts.app')

@section('title', 'Edit Team')

@section('content')
    <div class="container mt-5">
        <h1>Edit Team</h1>
        <form action="{{ route('teams.update', $team->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Team Name</label>
                <input type="text" name="name" class="form-control" value="{{ $team->name }}" required>
            </div>

            <div class="mb-3">
                <label for="color" class="form-label">Team Color</label>
                <input type="color" name="color" class="form-control" value="{{ $team->color }}" required>
            </div>

            <div class="mb-3">
                <label for="font_color" class="form-label">Font Color</label>
                <input type="color" name="font_color" class="form-control" value="{{ $team->font_color }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Update Team</button>
        </form>
    </div>
@endsection
