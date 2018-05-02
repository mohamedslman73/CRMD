<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Api\ApiController;
use App\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class roommessages extends ApiController
{
    public function roomMessages(Request $request)
    {
        $this->validate($request,[
            'room_id'=>'required',
        ]);
        $message = Message::where('room_id',$request->room_id)
//                             ->orderBy('created_at','asc')


            ->get();
        return $this->fire($message);
    }
}
