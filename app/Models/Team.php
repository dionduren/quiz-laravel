<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = ['name', 'score', 'font_color'];

    // Define the relationship to team scores
    public function teamScores()
    {
        return $this->hasMany(TeamScore::class);
    }
}
