<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable=['id','name'];
    protected $dates = ['created_at','updated_at'];

    public function messages(){

        return $this->hasMany(Message::class);
    }
    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

}
