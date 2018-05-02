<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    //
    protected $table = "user_types";
    protected $fillable = ["name_ar", "name_en","level","type"];

    public function user()
    {
        return $this->belongsTo(User::class,'type_id');
    }

}
