<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeWorks extends Model
{
    protected $table ="home_works";
    protected $fillable = ["name","description","score","weight","type","deadline","file","subject_id","class_id"];

    public function classes()
      {
         return $this->hasMany(Classes::class,'class_id');
      }

      public function subject()
      {
          return $this->belongsTo(Subject::class,'subject_id');
      }

      public function files()
      {
          return $this->hasMany(HomeworkFiles::class,'homework_id');
      }
    public function assignments()
    {
        return $this->hasMany(Assignment::class,'homework_id');
    }
}
