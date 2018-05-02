<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    //
  /*  public function days()
    {
        return $this->hasMany(Day::class);
    }*/
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
    public function day()
    {
        return $this->belongsTo(Day::class);
    }
}
