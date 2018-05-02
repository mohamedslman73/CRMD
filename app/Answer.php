<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable=['id','ans_text','is_right','question_id','created_at','updated_at'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
