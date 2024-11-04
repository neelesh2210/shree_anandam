<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SocialController extends Controller
{

    public function index(){
        $socials = About::where(function($query){
            $query->where('type','instagram')->orWhere('type','youtube')->orWhere('type','facebook');
        })->get();

        return view('admin.social.index',compact('socials'),['page_title'=>'Social']);
    }

    public function create(){
        return view('admin.social.create',['page_title'=>'Add Social']);
    }

    public function store(Request $request){
        $request->validate([
            'type'  =>  'required|in:instagram,youtube,facebook',
            'link' =>  'required'
        ]);

        $social = new About;
        $social->type = $request->type;
        $social->about = $request->link;
        $social->save();

        return redirect()->route('admin.social.index')->with('success','Social Added Successfully!');
    }

    public function destroy($id){
        About::where('id',$id)->delete();

        return redirect()->route('admin.social.index')->with('success','Social Deleted Successfully!');
    }

}
