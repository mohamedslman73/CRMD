<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DivisionTerms extends Model
{
    //
    protected $table = "divisions_terms";
    protected $fillable = ["start_date","end_date","division_id"];

    public function division()
    {
        return $this->belongsTo(Division::class,'division_id');
    }
}
