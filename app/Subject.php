<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    //
    protected $table = "subjects";
   // protected $fillable = ["grade_id"];

    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }
    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }
    public function addgrade()
    {
        return $this->hasMany(Addgrade::class);
    }
}
