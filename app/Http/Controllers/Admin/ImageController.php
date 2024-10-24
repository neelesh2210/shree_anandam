<?php

namespace App\Http\Controllers\Admin;

use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ImageController extends Controller
{

    public function index(){
        $images = Image::latest('type')->get();

        return view('admin.image.index',compact('images'),['page_title'=>'Images']);
    }

    public function create(){
        return view('admin.image.create',['page_title'=>'Add Image']);
    }

    public function store(Request $request){
        $request->validate([
            'image'=>'required|mimes:png,jpg,jpeg,webp',
            'type'=>'required|in:gallery,slider,popup,banner',
        ]);

        if($request->type == 'popup'){
            $image = Image::where('type','popup')->first();
        }
        if(!isset($image)){
            $image = new Image;
        }
        $image->image = imageUpload($request->file('image'),'backend/assets/image/images');
        $image->type = $request->type;
        $image->save();

        return redirect()->route('admin.image.index')->with('success','Image Added Successfully!');
    }

    public function destroy($id){
        $image = Image::where('id',$id)->delete();

        return redirect()->route('admin.image.index')->with('error','Image Deleted Successfully!');
    }

}
