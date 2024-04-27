<?php

namespace App\Http\Controllers\Api;

use Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\CampaignDonation;
use App\Http\Controllers\Controller;

class CampaignDonationController extends Controller
{

    public function store(Request $request){
        $request->validate([
            'campaign_slug'=>'required|exists:campaigns,slug,is_active,1',
            'donation_amount'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/|min:1',
            'pan_number'=>'nullable|min:10|max:10',
            'aadhar_number'=>'nullable|min:12|max:12',
        ]);

        if($request->donation_amount > 11 && !$request->pan_number){
            return response()->json(['message'=>'Pan Number is Required if you Donate more then 11!','errors'=>['pan_number'=>['Pan Number is Required if you Donate more then 11!']],'status'=>422],422);
        }

        $user = User::where('id',Auth::user()->id)->where('is_block','0')->where('is_verify','1')->with('userDetail')->first();
        if($user){
            if($user->is_block == '1'){
                return response()->json(['message'=>'You can not Donate because your ID is Blocked!','status'=>422],422);
            }
            if($user->is_verify == '0'){
                return response()->json(['message'=>'You can not Donate because your ID is not Verified!','status'=>422],422);
            }

            $campaign = Campaign::where('slug',$request->campaign_slug)->where('is_active','1')->first();
            if(!$campaign){
                return response()->json(['message'=>'Campaign Not Found!','status'=>422],422);
            }

            $donation_number = time().mt_rand(1111,9999);
            $this_financial_year_total_doantion_count = CampaignDonation::where('payment_status','success')->whereBetween('created_at', [currentFinancialYear()['financial_year_start'],currentFinancialYear()['financial_year_end']])->count();
            $receipt_number = Carbon::now()->format('Y').$this_financial_year_total_doantion_count+1;

            $campaign_donation = new CampaignDonation;
            $campaign_donation->donation_number = $donation_number;
            $campaign_donation->receipt_number = $receipt_number;
            $campaign_donation->user_id = Auth::user()->id;
            $campaign_donation->campaign_id = $campaign->id;
            $campaign_donation->donation_amount = $request->donation_amount;
            $campaign_donation->user_detail = $user;
            $campaign_donation->campaign_detail = $campaign;
            $campaign_donation->document_detail = ['pan_number'=>$request->pan_number,'aadhar_number'=>$request->aadhar_number];
            $campaign_donation->payment_status = 'success';
            $campaign_donation->save();

            return response()->json(['message'=>'Donation Successfull!','status'=>200],200);
        }else{
            return response()->json(['message'=>'User Not Found!','status'=>422],422);
        }

    }

}
