<?php

namespace App\Http\Controllers\Api\Messages;

use App\Message;
use App\Room;
use App\RoomUser;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use LRedis;

class createroom extends Controller
{
    public function createroom(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'sender_id' => 'required',
            'body' => 'required',
        ]);
        $sender_name = User::find($request->sender_id)->name;
        $token = array();
        $msg = array(
            'title' => '',
            'body' => 'There are a new Message From '.$sender_name,
            'image' => '',/*Default Icon*/
            'sound' => 'mySound'/*Default sound*/
        );
        if (!$request->has('room_id')) {

            $room = new Room();
            $room->name = uniqid();
            $room->save();

            if (is_array($request->user_id)) {

                foreach ($request->user_id as $user) {
                    $room_user = new RoomUser();
                    $room_user->user_id = $user;
                    $room_user->sender_id = $request->sender_id;
                    $room_user->room_id = $room->id;


                  //  $room_user->save();

                }
                 $refresh= User::whereIn('id',$request->user_id)->get(['refresh_token']);
                foreach ($refresh as $value)
                {
                    $token [] = $value->refresh_token;
                }
                notify1($token, $msg);
            }

           // return $token;
            $message = new Message();
            $message->body = $request->body;
            $message->room_id = $room->id;
            $message->user_id = $request->sender_id;
            $message->save();
            $redis = LRedis::connection();
            $redis->publish('message', $message);

            return response(['scode'=>200,'message'=>$message]);

        }
        if ($request->has('room_id')) {

            $message = new Message();
            $message->body = $request->body;
            $message->room_id = $request->room_id;
            $message->user_id = $request->sender_id;

            $var = RoomUser::where('sender_id',$request->sender_id)->distinct()->get(['user_id']);
          //  $tt = User::find($request->sender_id)->refresh_token;
            $message->save();
            $array = array();
            foreach ($var as $value)
            {
                $array [] = $value->user_id;
            }
            //  return $array;
            $token =array();
            $refresh = User::whereIn('id',$array)->get(['refresh_token']);
            foreach ($refresh as $any)
            {
                $token [] = $any->refresh_token;
            }
        // return $token;
            notify1($token, $msg);
            $redis = LRedis::connection();
            $redis->publish('message', $message);


            return response(['scode'=>200,'message'=>$message]);
        }
    }
}
