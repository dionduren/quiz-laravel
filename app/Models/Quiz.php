<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    // Fillable fields for mass assignment
    protected $fillable = ['category', 'question', 'answer', 'image', 'audio', 'lyrics_json', 'session'];

    // Cast the lyrics_json to an array when retrieved
    protected $casts = [
        'lyrics_json' => 'array',
    ];
}
