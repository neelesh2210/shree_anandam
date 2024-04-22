<?php

namespace App\Http\Controllers\Api\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function login(Request $request){
        $this->validate($request,[
            'phone_number'=>'required|integer|digits:10|exists:users,phone_number',
            'password'=>'required|min:6'
        ]);

        if (Auth::attempt(['phone_number' => $request->phone_number, 'password' => $request->password])) {
            $user = User::where('phone_number',$request->phone_number)->first();
            $user->access_token =  $user->createToken('MyApp')->plainTextToken;

            return response()->json(['access_token'=>$user->access_token,'message'=>'Login Successfully!','status'=>200],200);
        }
        return response()->json(['message'=>'Incorrect Credentials!'],401);
    }

}
