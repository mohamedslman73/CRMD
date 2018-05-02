<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolYears extends Model
{
    //
    protected $table = "school_years";
    protected $fillable = ["year_name","start_date","end_date","school_id"];

    public function getDivisionsTerms()
    {
    	return $this->hasMany(Division_Terms::class);
    }
}
