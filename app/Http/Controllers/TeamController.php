<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\Score;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $teams = Team::all();
        return view('teams.index', ['teams' => $teams]);
    }

    public function create()
    {
        return view('teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7', // Validate the background color as a hex code
            'font_color' => 'required|string|max:7', // Validate the font color as a hex code
        ]);

        Team::create([
            'name' => $request->name,
            'color' => $request->color,
            'font_color' => $request->font_color,
        ]);

        return redirect()->route('teams.manage')->with('success', 'Team created successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7', // Validate the background color as a hex code
            'font_color' => 'required|string|max:7', // Validate the font color as a hex code
        ]);

        $team = Team::findOrFail($id);
        $team->update([
            'name' => $request->name,
            'color' => $request->color,
            'font_color' => $request->font_color,
        ]);

        return redirect()->route('teams.manage')->with('success', 'Team updated successfully!');
    }

    public function edit($id)
    {
        $team = Team::findOrFail($id);
        return view('teams.edit', ['team' => $team]);
    }

    public function destroy($id)
    {
        Team::destroy($id);
        return redirect()->route('teams.index')->with('success', 'Team deleted successfully.');
    }

    public function manageTeams()
    {
        $teams = Team::all();
        return view('teams.manage', compact('teams'));
    }

    public function updateColor(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->color = $request->input('color');
        $team->save();

        return response()->json(['success' => true]);
    }
}
