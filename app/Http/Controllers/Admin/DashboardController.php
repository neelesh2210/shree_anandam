<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\CampaignDonation;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    function __construct(){
        $this->middleware('permission:dashboard', ['only'=>['index']]);
    }

    public function index(){
        $total_user = User::count();
        $total_active_campaign = Campaign::where('is_active','1')->count();
        $total_donation = CampaignDonation::count();
        $total_donation_amount = CampaignDonation::sum('donation_amount');

        return view('admin.dashboard',compact('total_user','total_active_campaign','total_donation','total_donation_amount'),['page_title'=>'Dashboard']);
    }

}
