<?php

namespace App\Http\Controllers\Api\Messages;
use Illuminate\Support\Facades\Redis;
use App\Message;
use App\User;
use Predis;
use LRedis;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateMessage extends Controller
{
    //

    public function getMessagesNotification(Request $request)
    {
             /*
              * this method get the messages that has not readed yet to this user
              */
        $this->validate($request,[
            'receiver_id'=>'required',
        ]);

        $notifications = Message::where('read',0)
                                      ->where('receiver_id',$request->receiver_id)
                                      ->orderBy('created_at','desc')
                                      ->get();
       return response(['data'=>$notifications]);
    }

    public function getMessages(Request $request)
    {
        /*
        * this method get all messages to this user
        */
        $this->validate($request,[
            'receiver_id'=>'required',
            ]);
        $messages = Message::where('receiver_id',$request->receiver_id)
                              ->orderBy('created_at','desc')
                               ->get();//paginate(2);

        return response(['data'=>$messages]);
    }

    public function getMessageById(Request $request)
    {
        $this->validate($request,[
            'message_id'=>'required'
        ]);
        $message = Message::where('id',$request->message_id)->first();
        if ($message->read ==0)
        {
            $message->read = 1;
            $message->save();
        }
        return response(['data'=>$message]);
    }

    public function getMessageSent(Request $request)
    {
        /*
        * this method get all messages to this user
        */
        $this->validate($request,[

            'api_token'=>'required|exists:user_tokens,api_token'
        ]);

        $userID = UserTokens::where('api_token',$request->api_token)->value('user_id');
        $messages = Message::where('sender_id',$userID)
            ->orderBy('created_at','desc')
            ->get();//paginate(2);

        return response(['data'=>$messages]);
    }

    public function createMessage(Request $request)
    {
       $this->validate($request,[
           'api_token'=>'required|exists:user_tokens,api_token',
           'body'=>'required',
           'receiver_id'=>'required|exists:users,id',
       ]);

           $sender_id = UserTokens::where('api_token',$request->api_token)->value('user_id');
           $sender_type_id = User::where('id',$sender_id)->value('type_id');
           $receiver_type_id = User::where('id',$request->receiver_id)->value('type_id');

      if (($sender_type_id == 4 or $sender_type_id == 5) and $receiver_type_id == 3)
       {
           return 'You Can not send messages here';
       }
       else{
           $message = new Message();
           $message->body = $request->body;
           $message->receiver_id = $request->receiver_id;
           $message->sender_id = $sender_id;
           $message->save();

           $redis = LRedis::connection();
           $redis->publish('message',$message);
           return response(['data'=>$message]);
       }
    }
}
