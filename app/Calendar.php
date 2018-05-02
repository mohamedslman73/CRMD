<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    //
    protected $table = "calendars";
    protected $fillable = ["name","description","start_at","end_at","start_time","school_id"];
    public function school()
    {
        return $this->hasOne(School::class,'school_id');
    }
}
