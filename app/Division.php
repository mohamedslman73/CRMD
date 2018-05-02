<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    //
    protected $table = "divisions";
    protected $fillable = ["name","lessons_per_day","lesson_duration","day_start_at","day_end_at"
    ,"school_id","education_type_id"];
    public function divisionsDaysOff()
    {
    	return $this->hasMany(DivisionDaysOff::class,'division_id');
    }


    public function divisionBreaks()
    {
    	return $this->hasMany(DivisionBreaks::class,'division_id');
    }


    public function getDivisionsTerms()
    {
    	return $this->hasMany(DivisionTerms::class,'division_id');
    }
    public function grade()
    {
        return $this->hasMany(Grade::class,'division_id');
    }
    
}
