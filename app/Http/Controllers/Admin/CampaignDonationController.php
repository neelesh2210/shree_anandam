<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CampaignDonation;
use App\Http\Controllers\Controller;

class CampaignDonationController extends Controller
{

    public function index(Request $request){
        $search_start_date = $request->search_start_date;
        $search_end_date = $request->search_end_date;
        $search_campaign = $request->search_campaign;
        $search_payment_status = $request->search_payment_status;
        $search_key = $request->search_key;

        $campaign_donations = CampaignDonation::latest();

        if($search_start_date){
            $d1=strtotime($search_start_date);
            $d2=strtotime($search_end_date);
            $da1=date('Y-m-d',$d1);
            $da2=date('Y-m-d',$d2);
            $startDate = Carbon::createFromFormat('Y-m-d', $da1)->startOfDay();
            $endDate = Carbon::createFromFormat('Y-m-d', $da2)->endOfDay();

            $campaign_donations = $campaign_donations->whereBetween('created_at', [$startDate, $endDate]);
        }

        if($search_campaign){
            $campaign_donations = $campaign_donations->where('campaign_id',$search_campaign);
        }

        if($search_payment_status){
            $campaign_donations = $campaign_donations->where('payment_status',$search_payment_status);
        }

        if($search_key){
            $campaign_donations = $campaign_donations->where(function($query) use ($search_key){
                $query->where('donation_number',$search_key)->orWhere('receipt_number',$search_key)->orWhere('user_detail->name','LIKE','%'.$search_key.'%')->orWhere('user_detail->phone_number',$search_key)->orWhere('user_detail->referral_code',$search_key)->orWhere('donation_amount->pan_number',$search_key)->orWhere('donation_amount->aadhar_number',$search_key);
            });
        }

        $campaign_donations = $campaign_donations->paginate(10);

        if($request->ajax()){
            return view('admin.campaign_donation.table',compact('campaign_donations','search_start_date','search_end_date','search_campaign','search_payment_status','search_key'));
        }

        return view('admin.campaign_donation.index',compact('campaign_donations','search_start_date','search_end_date','search_campaign','search_payment_status','search_key'),['page_title'=>'Campagin Donation List']);
    }

}
