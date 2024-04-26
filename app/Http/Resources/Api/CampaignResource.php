<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{

    public function toArray(Request $request): array{
        // return parent::toArray($request);
        return [
            'slug'                  =>  $this->slug,
            'title'                 =>  $this->title,
            'image'                 =>  asset('backend/assets/image/campaigns/'.$this->image),
            'total_raise_amount'    =>  $this->total_raise_amount,
            'total_raised_amount'   =>  $this->total_raised_amount,
            'short_description'     =>  $this->short_description,
            'description'           =>  $this->description,
        ];
    }
}
