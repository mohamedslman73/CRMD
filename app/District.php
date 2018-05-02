<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table    = "districts";
    protected $fillable = ["name_ar", "name_en","city_id"];

    protected $maps = ['name_ar' => 'name','name_en'=>"name"];
    protected $hidden = ["name_ar", "name_en"];
    protected $appends = ['name'];


    public function city()
    {
        return $this->belongsTo(City::class,'city_id');
    }

    public function getNameAttribute()
    {
        return $this->attributes['name_'.app()->getLocale()];
    }
}
