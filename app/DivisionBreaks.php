<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DivisionBreaks extends Model
{
    protected $table = "division_breaks";
    protected  $fillable = ["name","duration","division_id"];

    public function division()
    {
      return $this->belongsTo(Division::class,'division_id');
    }

}
