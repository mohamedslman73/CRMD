<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = "countries";
    protected $fillable = ["name_ar", "name_en"];

    protected $maps     = ['name_ar' => 'name','name_en'=>"name"];
    protected $hidden   = ["name_ar", "name_en"];
    protected $appends  = ['name'];

    public function cities()
    {
        return $this->hasMany(City::class,'country_id');
    }

    public function getNameAttribute()
    {
        return $this->attributes['name_'.app()->getLocale()];
    }



}
