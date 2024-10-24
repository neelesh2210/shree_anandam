<?php

namespace App\Http\Controllers\Api;

use Auth;
use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProfileResource;

class ProfileController extends Controller
{

    public function index(){
        $user = new ProfileResource(User::with('userDetail','referrer','referral')->find(Auth::user()->id));

        return response()->json(['user'=>$user,'message'=>'Profile Retrived Successfully!','status'=>200],200);
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|max:30',
            'phone_number'=>'required|integer|digits:10|unique:users,phone_number,'.Auth::user()->id.',id',
            'address'=>'required',
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        $user->save();

        return $user = $this->index();
    }

    public function updateProfilePhoto(Request $request){
        $request->validate([
            'photo'=>'required|mimes:png,jpg,jpeg,webp'
        ]);

        $user_detail = UserDetail::where('user_id',Auth::user()->id)->first();
        if(!$user_detail){
            $user_detail = new UserDetail;
            $user_detail->user_id = Auth::user()->id;
        }
        $user_detail->photo = imageUpload($request->file('photo'),'backend/assets/image/documents/');
        $user_detail->save();

        return response()->json(['url'=>asset('backend/assets/image/documents/'.$user_detail->photo),'message'=>'Profile Photo Upadted Successfully!','status'=>200],200);
    }
}
