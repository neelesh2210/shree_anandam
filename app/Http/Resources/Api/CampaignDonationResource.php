<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CampaignDonationResource extends JsonResource
{

    public function toArray(Request $request): array{
        // return parent::toArray($request);

        return [
            'donation_number'   =>  $this->donation_number,
            'receipt_number'   =>  $this->receipt_number,
            'donation_amount'   =>  $this->donation_amount,
            'user_detail'   =>  ['name'=>json_decode($this->user_detail)->name,'phone_number'=>json_decode($this->user_detail)->phone_number,'address'=>json_decode($this->user_detail)->address,'referral_code'=>json_decode($this->user_detail)->referral_code],
            'campaign_detail'   =>  ['slug'=>json_decode($this->campaign_detail)->slug,'title'=>json_decode($this->campaign_detail)->title,'image'=>asset('backend/assets/image/campaigns/'.json_decode($this->campaign_detail)->image)],
            'document_detail'   =>  $this->document_detail,
            'payment_status'   =>  $this->payment_status,
            'receipt_url'   =>  null,
        ];
    }
}
