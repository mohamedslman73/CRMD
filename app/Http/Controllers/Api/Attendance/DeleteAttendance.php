<?php

namespace App\Http\Controllers\Api;

use App\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;

class DeleteAttendance extends ApiController
{
    //

    public function DeleteAttendance(Request $request)
    {
        $this->validate($request,[
            'id'=>'required|exists:attendances,id',
        ]);

        $attendace = Attendance::find($request->id);
        if(!$attendace){
            return $this->fire([],null,['This Attendance  Not Exist']);
        }
        $deleted = $attendace->delete();
        if ($deleted) {
            return response()->json(['status' => 200, 'message' => 'Attendance Deleted Successfully']);
        }
        else
        {
            return response()->json(['status'=>400,'message'=>'Some Errors Happened']);

        }
    }
}
