<?php

namespace App\Http\Controllers\Admin\Auth;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

    public function __construct() {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function showLoginForm() {
        return view('admin.auth.login');
    }

    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email|exists:admins,email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            return redirect()->route(Auth::guard('admin')->user()->getAllPermissions()[0]->route_name);
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))->withErrors(['password' => ['These credentials don\'t match our records.','Or Incorrect Password']]);
    }

    public function logout() {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }

}
