<?php

namespace App\Services;

use App\Models\Question;

class QuestionsService
{
    /**
     * Get a listing of questions
     *
     * @return \Illuminate\Database\Eloquent\Collection List of questions
     */
    public function index()
    {
        return Question::all();
    }
}
