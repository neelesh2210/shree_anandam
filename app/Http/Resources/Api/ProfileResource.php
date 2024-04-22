<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{

    public function toArray(Request $request): array {
        // return parent::toArray($request);
        return [
            'name'                      =>  $this->name,
            'phone_number'              =>  $this->phone_number,
            'address'                   =>  $this->address,
            'referral_code'             =>  $this->referral_code,
            'referrer_detail'           =>  ['name'=>$this->referrer->name,'phone_number'=>$this->referrer->phone_number,'address'=>$this->referrer->address,'referral_code'=>$this->referrer->referral_code,'photo'=>optional(optional($this->referrer)->userDetail)->photo?asset('backend/assets/image/documents/'.optional($this->userDetail)->photo):asset('backend/assets/image/no-image.png'),],
            'photo'                     =>  optional($this->userDetail)->photo?asset('backend/assets/image/documents/'.optional($this->userDetail)->photo):asset('backend/assets/image/no-image.png'),
        ];
    }
}
