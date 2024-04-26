<?php

namespace App\Http\Controllers\Admin;

use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CampaignController extends Controller
{

    public function index(Request $request){
        $search_is_active = $request->search_is_active;
        $search_key = $request->search_key;

        $campaigns = Campaign::latest();

        if($search_is_active){
            $campaigns = $campaigns->where('is_active',$search_is_active);
        }

        if($search_key){
            $campaigns = $campaigns->where('title','LIKE','%'.$search_key.'%');
        }

        $campaigns = $campaigns->paginate(10);

        if($request->ajax()){
            return view('admin.campaign.table',compact('campaigns','search_is_active','search_key'));
        }
        return view('admin.campaign.index',compact('campaigns','search_is_active','search_key'),['page_title'=>'Campaign List']);
    }

    public function create(){
        return view('admin.campaign.create',['page_title'=>'Add Campaign']);
    }

    public function store(Request $request){
        $request->validate([
            'title'=>'required|max:200',
            'image'=>'required|mimes:png,jpg,jpeg,webp',
            'total_raise_amount'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'short_description'=>'nullable|max:500',
        ]);

        $campaign = new Campaign;
        $campaign->slug = Str::slug($request->title).rand(111,999);
        $campaign->title = $request->title;
        $campaign->image = imageUpload($request->file('image'),'backend/assets/image/campaigns');
        $campaign->total_raise_amount = $request->total_raise_amount;
        $campaign->short_description = $request->short_description;
        $campaign->description = $request->description;
        $campaign->save();

        return redirect()->route('admin.campaigns.index')->with('success','Campaign Added Successfully!');
    }

    public function edit(Campaign $campaign){
        return view('admin.campaign.edit',compact('campaign'),['page_title'=>'Edit Campaign']);
    }

    public function update(Request $request,Campaign $campaign){
        $request->validate([
            'title'=>'required|max:200',
            'image'=>'nullable|mimes:png,jpg,jpeg,webp',
            'total_raise_amount'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'short_description'=>'nullable|max:500',
        ]);

        $campaign->title = $request->title;
        if($request->hasFile('image')){
            $campaign->image = imageUpload($request->file('image'),'backend/assets/image/campaigns');
        }
        $campaign->total_raise_amount = $request->total_raise_amount;
        $campaign->short_description = $request->short_description;
        $campaign->description = $request->description;
        $campaign->save();

        return redirect()->route('admin.campaigns.index')->with('success','Campaign Updated Successfully!');
    }

    public function status($id,$status){
        $campaign = Campaign::find($id);
        if($campaign){
            $campaign->is_active = $status;
            $campaign->save();

            if($status == '1'){
                return back()->with('success','Campaign Actived Successfully!');
            }else{
                return back()->with('error','Campaign Inactived Successfully!');
            }
        }else{
            return back()->with('error','Campaign Not Found!');
        }
    }

}
