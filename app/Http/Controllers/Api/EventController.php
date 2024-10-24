<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\EventResource;

class EventController extends Controller
{

    public function index(){
        $events = EventResource::collection(Event::latest()->paginate(20));

        return response()->json([
            'events'=>$events,
            'links'                     =>[
                'first_page_url'        => $events->url($events->firstItem()),
                'last_page_url'         => $events->url($events->lastPage()),
                'next_page_url'         => $events->nextPageUrl(),
                'prev_page_url'         => $events->previousPageUrl(),
            ],
            'message'=>'Event List Retrived Successfully!',
            'status'=>200
        ],200);
    }

}
