<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table    = "cities";
    protected $fillable = ["name_ar", "name_en","country_id"];

    protected $maps     = ['name_ar' => 'name','name_en'=>"name"];
    protected $hidden   = ["name_ar", "name_en"];
    protected $appends  = ['name'];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    public function districts()
    {
        return $this->hasMany(District::class,'city_id');
    }

    public function getNameAttribute()
    {
        return $this->attributes['name_'.app()->getLocale()];
    }
}
