<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
/*    protected $visible=['id','title','description','week_num','subject_id','school_id','grade_id','questions','answers'];*/
    protected $fillable=['title','description','week_num','q_link','subject_id','created_at','updated_at','school_id','grade_id'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function materialFile()
    {
        return $this->hasMany(MaterialFile::class);
    }
}
