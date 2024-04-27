<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    function __construct(){
        $this->middleware('permission:dashboard', ['only'=>['index']]);
    }

    public function index(){
        $total_user = User::count();
        $total_active_campaign = Campaign::where('is_active','1')->count();

        return view('admin.dashboard',compact('total_user','total_active_campaign'),['page_title'=>'Dashboard']);
    }

}
