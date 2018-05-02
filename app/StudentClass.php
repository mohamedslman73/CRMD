<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    //
    protected $table="student_classes";
    protected $fillable = ["user_id","class_id"];
    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');

    }
    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
}
