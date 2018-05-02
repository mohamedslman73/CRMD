<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $table = "attendances";

    public function users()
    {
        return $this->belongsTo(User::class,'user_id','id');
        //return $this->hasMany(User::class,'id','user_id');
    }
}
