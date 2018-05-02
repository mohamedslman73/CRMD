<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentGrades extends Model
{
    protected $fillable = ['user_id','total_score','addgrade_id'];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function addgrade()
    {
        return $this->belongsTo(Addgrade::class);
    }
}
