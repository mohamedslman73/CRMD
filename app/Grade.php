<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    //
    protected $table = "grades";
    protected $fillable = ["division_id","name"];

    public function division()
    {
       return $this->belongsTo(Division::class,'division_id');
    }
    public function classes()
    {
        return $this->hasMany(Classes::class,'grade_id');
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class,'grade_id');
    }
}
