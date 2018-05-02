<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolTypes extends Model
{
    //
    protected $table = "school_types";
    protected $fillable =["school_id","type_id"];

    public function educations()
    {
        return $this->hasMany(EducationTypes::class);
    }

}
