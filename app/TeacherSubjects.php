<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeacherSubjects extends Model
{
    //
    protected $table = "teacher_subjects";
    protected $fillable = ["user_id","class_id","subject_id"];

    public function classes()
    {
        return $this->belongsTo(Classes::class,'class_id');
    }
    public function subjects()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
}
