<?php

namespace App\Http\Controllers\Admin;

use DB;
use Hash;
use Auth;
use App\Models\Admin;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class StaffController extends Controller
{

    function __construct(){
        $this->middleware('permission:staff-list', ['only'=>['index']]);
        $this->middleware('permission:staff-create', ['only'=>['create', 'store']]);
        $this->middleware('permission:staff-edit', ['only'=>['edit', 'update']]);
        $this->middleware('permission:staff-delete', ['only'=>['destroy']]);
    }

    public function index(Request $request){
        if(Auth::guard('admin')->user()->id == 1){
            $staffs = Admin::latest()->paginate(10);
        }else{
            $staffs = Admin::whereNotIn('id',[1,2,Auth::guard('admin')->user()->id])->latest()->paginate(10);
        }

        return view('admin.staff.index',compact('staffs'),['page_title'=>'Staff List']);
    }

    public function create(){
        if(Auth::guard('admin')->user()->id == 1){
            $roles = Role::pluck('name','name')->all();
        }else{
            $roles = Role::whereNotIn('id',[1,2])->whereNotIn('id',Auth::guard('admin')->user()->roles->pluck('id'))->pluck('name','name')->all();
        }

        return view('admin.staff.create',compact('roles'),['page_title'=>'Add Staff']);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = Admin::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('admin.staffs.index')->with('success','Staff Added Successfully');
    }

    public function edit($id){
        $staff = Admin::find($id);
        if(Auth::guard('admin')->user()->id == 1){
            $roles = Role::pluck('name','name')->all();
        }else{
            $roles = Role::whereNotIn('id',[1,2])->whereNotIn('id',Auth::guard('admin')->user()->roles->pluck('id'))->pluck('name','name')->all();
        }
        $userRole = $staff->roles->pluck('name','name')->all();

        return view('admin.staff.edit',compact('staff','roles','userRole'));
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $staff = Admin::find($id);
        $staff->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $staff->assignRole($request->input('roles'));

        return redirect()->route('admin.staffs.index')->with('success','Staff updated successfully');
    }

    public function destroy($id){
        Admin::find($id)->delete();

        return redirect()->route('admin.staffs.index')->with('success','Staff Deleted successfully');
    }

}
