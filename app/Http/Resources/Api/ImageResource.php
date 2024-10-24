<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{

    public function toArray(Request $request): array{
        // return parent::toArray($request);
        return [
            'image'         =>  asset('backend/assets/image/images/'.$this->image),
        ];
    }
}
