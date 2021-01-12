<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Response extends Eloquent
{
    protected $table = 'responses';

    protected $guarded = ['id'];

    public function mbti()
    {
        return $this->belongsTo(MBTI::class, 'mbti_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
