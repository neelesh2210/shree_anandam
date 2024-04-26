<?php

namespace App\Http\Controllers\Api;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CampaignResource;

class CampaignController extends Controller
{

    public function index(){
        $campaigns = CampaignResource::collection(Campaign::where('is_active','1')->paginate(10));

        return response()->json([
            'campaigns'=>$campaigns,
            'links'                     =>[
                'first_page_url'        => $campaigns->url($campaigns->firstItem()),
                'last_page_url'         => $campaigns->url($campaigns->lastPage()),
                'next_page_url'         => $campaigns->nextPageUrl(),
                'prev_page_url'         => $campaigns->previousPageUrl(),
            ],
            'message'=>'campaign List Retrived Successfully!',
            'status'=>200
        ],200);
    }

}
