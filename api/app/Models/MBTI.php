<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

class MBTI extends Eloquent
{
    protected $table = 'mbtis';

    public function responses()
    {
        return $this->hasMany(Response::class, 'mbti_id');
    }
}
