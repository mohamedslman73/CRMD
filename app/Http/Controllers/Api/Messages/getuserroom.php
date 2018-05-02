<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Api\ApiController;
use App\Message;
use App\Room;
use App\RoomUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getuserroom extends ApiController
{
    public function getuserroom(Request $request)
    {
        $this->validate($request,[
           'user_id'=>'required'
        ]);

        $room = RoomUser::where('user_id',$request->user_id)
                          ->orWhere('sender_id',$request->user_id)
                          ->with('room')
                          ->get();

        foreach ($room as $value) {
            $room_id = $value->room_id;

            $user_id = Message::where('room_id', $room_id)->value('user_id');
            $name = User::where('id', $user_id)->value('name');

            $value->room->name = $name;

        }
        return $this->fire($room);
    }
}
