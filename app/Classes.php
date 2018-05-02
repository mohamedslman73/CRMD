<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    //
    protected $table= "classes";
    protected $fillable = ["grade_id"];

    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }

   public function students()
    {
        return $this->belongsToMany(User::class,'student_classes','class_id','user_id');
    }
}
