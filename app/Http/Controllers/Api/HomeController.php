<?php

namespace App\Http\Controllers\Api;

use App\Models\About;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ImageResource;

class HomeController extends Controller
{

    public function index(){
        $sliders = Image::where('type','slider')->latest()->pluck('image')->map(function($image) {
            return asset('backend/assets/image/images/'.$image);
        });

        $banners = Image::where('type','banner')->latest()->pluck('image')->map(function($image) {
            return asset('backend/assets/image/images/'.$image);
        });

        $popup = Image::where('type','popup')->first();

        if($popup){
            $popup = asset('backend/assets/image/images/'.$popup->image);
        }

        $about_sansthan = About::where('type','sansthan')->first()?->about;
        $about_guruji = About::where('type','guruji')->first()?->about;
        $social_links = About::whereIn('type',['youtube','instagram'])->get(['type','about']);

        return response()->json([
                                    'sliders'=>$sliders,
                                    'banners'=>$banners,
                                    'popup'=>$popup,
                                    'about_sansthan'=>$about_sansthan,
                                    'about_guruji'=>$about_guruji,
                                    'social_links'=>$social_links,
                                    'message'=>'Home Data Retrived Successfully!',
                                    'status'=>200
                                ],200);
    }

    public function gallery(){
        $galleries = ImageResource::collection(Image::where('type','gallery')->latest()->paginate(20));

        return response()->json([
            'galleries'=>$galleries,
            'links'                     =>[
                'first_page_url'        => $galleries->url($galleries->firstItem()),
                'last_page_url'         => $galleries->url($galleries->lastPage()),
                'next_page_url'         => $galleries->nextPageUrl(),
                'prev_page_url'         => $galleries->previousPageUrl(),
            ],
            'message'=>'Gallery Retrived Successfully!',
            'status'=>200
        ],200);
    }

}
