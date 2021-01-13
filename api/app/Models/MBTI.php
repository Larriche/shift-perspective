<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

class MBTI extends Eloquent
{
    use SoftDeletes;

    protected $table = 'mbtis';

    protected $fillable = ['mbti', 'email'];

    public function responses()
    {
        return $this->hasMany(Response::class, 'mbti_id');
    }
}
