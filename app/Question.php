<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
/*    protected $visible=['id','q_text','q_type','material_id'];*/
    protected $fillable=['id','q_text','q_type','material_id','created_at','updated_at'];
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
