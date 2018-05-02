<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addgrade extends Model
{
    //
    protected $fillable = ['class_id','subject_id','total_score','grade_name','weight','type'];
    public function students()
    {
        return $this->hasMany(StudentGrades::class);
    }
    public function subject()
    {
        return $this->hasMany(Subject::class,'id','subject_id');
    }
}
