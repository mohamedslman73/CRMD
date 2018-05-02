<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Behavior extends Model
{
    protected $fillable=['title','degree','icon','type','class_id','school_id','subject_id'];
    public function studentBehaviors()
    {
        return $this->hasMany(StudentBehavior::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class,'student_id','id');
    }
    public function studentBehavior()
    {
        return $this->hasMany(StudentBehavior::class,'behavior_id','id');
    }
}
