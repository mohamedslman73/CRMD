<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    //
    protected $table = "schools";
    protected $fillable =["name","logo","vision","mission","address","latitude","longitude","district_id"];

    public function divisions()
    {
    	return $this->hasMany(Division::class,'school_id');
    }

    public function schoolYears()
    {
    	return $this->hasMany(SchoolYears::class,'school_id');
    }

    public function emails()
    {
    	return $this->hasMany(SchoolEmails::class,'school_id');
    }
    public function phoneNumbers()
    {
        return $this->hasMany(SchoolPhoneNumbers::class,'school_id');
    }
    public function schoolTypes()
    {
        return $this->hasMany(SchoolTypes::class,'school_id');
    }
    public function userSchool()
    {
        return $this->hasMany(User::class,'school_id');
    }
    public function calendar()
    {
        return $this->belongsTo(Calendar::class,'school_id');
    }
}
