<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{

    public function toArray(Request $request): array {
        // return parent::toArray($request);
        $data = [
            'name'                      =>  $this->name,
            'phone_number'              =>  $this->phone_number,
            'address'                   =>  $this->address,
            'referral_code'             =>  $this->referral_code,
            'referrer_detail'           =>  ['name'=>$this->referrer?->name,'phone_number'=>$this->referrer?->phone_number,'address'=>$this->referrer?->address,'referral_code'=>$this->referrer?->referral_code,'photo'=>$this->referrer?->userDetail?->photo?asset('backend/assets/image/documents/'.$this->userDetail?->photo):asset('backend/assets/image/no-image.png'),],
            'photo'                     =>  $this->userDetail?->photo?asset('backend/assets/image/documents/'.$this->userDetail?->photo):asset('backend/assets/image/no-image.png'),
            'referral'                  =>  []
        ];

        $referral_arr = [];

        foreach ($this->referral as $referral) {
            $referral_arr[] = ['name'=>$referral?->name,'phone_number'=>$referral?->phone_number,'address'=>$referral?->address,'referral_code'=>$referral?->referral_code,'photo'=>$referral?->userDetail?->photo?asset('backend/assets/image/documents/'.$referral?->photo):asset('backend/assets/image/no-image.png'),];
        }
        $data['referral'] = $referral_arr;

        return $data;
    }
}
