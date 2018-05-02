<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['room_id','user_id','body'];
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $appends = ['user'];

    public function getUserAttribute ()
    {
        return User::where('id',$this->user_id)->first();
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function room()
    {
        return $this->belongsTo(Room::class,'id','room_id');
    }
}
