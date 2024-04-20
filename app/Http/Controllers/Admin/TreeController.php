<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TreeController extends Controller
{

    public function index(){
        $users  = User::all();
        return view('admin.tree.index',compact('users'),['page_title'=>'Tree']);
    }

}
