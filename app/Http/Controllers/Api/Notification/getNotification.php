<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Api\ApiController;
use App\Notification;
use App\UserTokens;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class getNotification extends ApiController
{
    public function getNotification(Request $request)
    {
        $this->validate($request,[
            'api_token' =>'required|exists:user_tokens,api_token'
        ]);
        $userID = UserTokens::where('api_token',$request->api_token)->first()->user_id;
        $notification = Notification::where('user_id',$userID)->get();
        $count =  Notification::where('user_id',$userID)->where('read',0)->count();
       foreach ($notification as $notify)
       {
           $notify->count = $count;
       }
        return $this->fire($notification);
    }


    public function getNotificationById(Request $request)
    {
        $this->validate($request,[
            'notification_id'=>'required'
        ]);
        $notification = Notification::where('id',$request->notification_id)->first();
        if ($notification->read ==0)
        {
            $notification->read = 1;
            $notification->save();
        }
        return response(['data'=>$notification]);
    }
}
