<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $fillable=['file','homework_id','student_id','created_at','updated_at'];
    public function homework()
    {
        return $this->belongsTo(HomeWorks::class,'homework_id');
    }
}
