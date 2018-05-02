<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentBehavior extends Model
{
    protected $fillable=['total','student_id','behavior_id'];
    public function student()
    {
        return $this->belongsTo(User::class,'users','user_id');
    }
    public function behavior()
    {
        return $this->belongsTo(Behavior::class,'behaviors');
    }
}
