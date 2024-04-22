<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    function __construct(){
        $this->middleware('permission:dashboard', ['only'=>['index']]);
    }

    public function index(){
        $total_user = User::count();
        return view('admin.dashboard',compact('total_user'),['page_title'=>'Dashboard']);
    }

}
