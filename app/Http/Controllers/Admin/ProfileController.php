<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function index(){
        return view('admin.profile');
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:admins,email,'.Auth::guard('admin')->user()->id.',id',
            'image'=>'nullable|mimes:png,jpg,jpeg,webp'
        ]);

        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->name = $request->name;
        $admin->email = $request->email;
        if($request->has('image')){
            $admin->avatar = imageUpload($request->file('image'),'backend/assets/image/avatars');
        }
        $admin->save();

        return back()->with('success','Profile Updated Succesfully!');
    }

    public function changePassword(Request $request){
        $request->validate([
            'password' => 'min:8|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:8'
        ]);

        $admin = Admin::find(Auth::guard('admin')->user()->id);
        $admin->password = Hash::make($request->password);
        $admin->save();

        return response()->json(['message'=>'Password Updated Successfully!']);
    }

}
