<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = ['team_id', 'session', 'score'];

    // Relationship: A score belongs to a team
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
