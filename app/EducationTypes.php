<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EducationTypes extends Model
{
    //
    protected $table = "education_types";
    protected $fillable = ["name_ar","name_en","terms_per_day"];

    public function getDivisions()
    {
    	return $this->hasMany(Division::class,'education_type_id');
    }
}
