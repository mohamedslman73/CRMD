<?php

namespace App\Http\Controllers\Api\Messages;

use App\Http\Controllers\Api\ApiController;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserToSend extends ApiController
{
    public function UserToSend(Request $request)
    {
        $user = User::take(10)->get();
       return $this->fire($user);
    }
}
