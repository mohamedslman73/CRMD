<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DivisionDaysOff extends Model
{
    //
    protected $table = "divisions_days_offs";
    protected $fillable = ["name","duration","division_id"];

    public function division()
    {
        return $this->belongsTo(Division::class,'division_id');
    }
}
