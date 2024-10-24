<?php

namespace App\Http\Controllers\Admin;

use App\Models\About;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutController extends Controller
{

    public function index(){
        $abouts = About::where(function($query){
            $query->where('type','sansthan')->orWhere('type','guruji');
        })->get();

        return view('admin.about.index',compact('abouts'),['page_title'=>'About']);
    }

    public function create(){
        return view('admin.about.create',['page_title'=>'Add About']);
    }

    public function store(Request $request){
        $request->validate([
            'type'  =>  'required|in:sansthan,guruji',
            'about' =>  'required'
        ]);

        $about = About::where('type',$request->type)->first();
        if(!$about){
            $about = new About;
            $about->type = $request->type;
        }
        $about->about = $request->about;
        $about->save();

        return redirect()->route('admin.about.index')->with('success','About Added Successfully!');
    }

    public function show($type){
        return $type = About::where('type',$type)->first();
    }

}
