<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{

    public function index(){
        $events = Event::latest()->get();

        return view('admin.event.index',compact('events'),['page_title'=>'Event']);
    }

    public function create(){
        return view('admin.event.create',['page_title'=>'Add Event']);
    }

    public function store(Request $request){
        $request->validate([
            'image'=>'required|mimes:png,jpg,jpeg,webp',
            'description'=>'required',
        ]);

        $event = new Event;
        $event->image = imageUpload($request->file('image'),'backend/assets/image/events');
        $event->description = $request->description;
        $event->save();

        return redirect()->route('admin.event.index')->with('success','Event Added Successfully!');
    }

    public function edit(Event $event){
        return view('admin.event.edit',compact('event'),['page_title'=>'Update Event']);
    }

    public function update(Request $request,Event $event){
        $request->validate([
            'image'=>'nullable|mimes:png,jpg,jpeg,webp',
            'description'=>'required',
        ]);

        if($request->has('image')){
            $event->image = imageUpload($request->file('image'),'backend/assets/image/events');
        }
        $event->description = $request->description;
        $event->save();

        return redirect()->route('admin.event.index')->with('success','Event Updated Successfully!');
    }

    public function destroy(Event $event){
        $event->delete();

        return redirect()->route('admin.event.index')->with('error','Event Deleted Successfully!');
    }

}
