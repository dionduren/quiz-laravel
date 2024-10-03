<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuizzesTable extends Migration
{
    public function up()
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->integer('session')->after('category'); // Add a session column
            $table->string('category'); // e.g., 'general knowledge', 'guess the picture'
            $table->text('question'); // The question text
            $table->string('answer'); // The correct answer
            $table->string('image')->nullable(); // Path to the image (optional)
            $table->string('audio')->nullable(); // Path to the audio file (optional)
            $table->text('lyrics_json')->nullable(); // JSON containing lyrics with timestamps (for "Guess the Lyric")
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quizzes');
    }
}
