<?php

namespace App\Http\Controllers\Api\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{

    public function registration(Request $request){
        $request->validate([
            'name'=>'required|max:30',
            'phone_number'=>'required|integer|digits:10|unique:users,phone_number',
            'address'=>'required',
            'password'=>'required|min:8',
            'referrer_code'=>'nullable|exists:users,referral_code'
        ]);

        $latest_user = User::oldest('id')->first();
        if($latest_user){
            $least_child_user = User::where('number_of_child','<',5)->oldest('id')->first();
            $parent_id = $least_child_user->id;
            if(!$request->referrer_code){
                $referrer_code = $latest_user->referral_code;
            }else{
                $referrer_code = $request->referrer_code;
            }
        }else{
            $parent_id = null;
            $referrer_code = $request->referrer_code;
        }

        $user = new User;
        $user->parent_id = $parent_id;
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->password = Hash::make($request->password);
        $user->referral_code = 'RIT'.mt_rand(11111111,99999999);
        $user->referrer_code = $referrer_code;
        $user->save();

        if(isset($least_child_user)){
            $least_child_user->number_of_child = $least_child_user->number_of_child + 1;
            $least_child_user->save();
        }

        $user->access_token =  $user->createToken('MyApp')->plainTextToken;

        return response()->json(['access_token'=>$user->access_token,'message'=>'User Registered Successfully!','status'=>200],200);
    }

}
