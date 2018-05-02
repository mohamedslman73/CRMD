<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGrades extends Model
{
    //
    protected $table = "user_grades";
    protected $fillable = ["user_id","grade_id"];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function Grade()
    {
      return $this->belongsTo(Grade::class);
    }
}
