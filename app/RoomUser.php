<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoomUser extends Model
{
    protected $fillable = ['room_id','user_id'];
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
//    protected $appends = ['user'];

//    public function getUserAttribute ()
//    {
//        return User::where('id',$this->user_id)->first();
//    }


}
