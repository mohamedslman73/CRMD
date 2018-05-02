<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $table = 'class_subjects';
    public function classes()
    {
        return $this->belongsTo(Classes::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }
}
