<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamScore extends Model
{
    use HasFactory;

    protected $fillable = ['team_id', 'session', 'score'];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
