<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{

    function __construct(){
        $this->middleware('permission:role-list', ['only'=>['index']]);
        $this->middleware('permission:role-create', ['only'=>['create', 'store']]);
        $this->middleware('permission:role-edit', ['only'=>['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only'=>['destroy']]);
    }

    public function index(Request $request){
        if(Auth::guard('admin')->user()->id == 1){
            $roles = Role::latest()->paginate(10);
        }else{
            $roles = Role::whereNotIn('id',[1,2])->whereNotIn('id',Auth::guard('admin')->user()->roles->pluck('id'))->latest()->paginate(10);
        }

        if($request->ajax()){
            return view('admin.roles.table',compact('roles'));
        }
        return view('admin.roles.index',compact('roles'),['page_title'=>'Role List']);
    }

    public function create(){

        if(Auth::guard('admin')->user()->id == 1){
            $permissionParent = Permission::groupBy('parent_name')->oldest('id')->get();
        }else{
            $roles_id = Auth::guard('admin')->user()->roles->pluck('id');
            $selected_permission = DB::table('role_has_permissions')->whereIn('role_id', $roles_id)->pluck('permission_id');

            $permissionParent = Permission::whereIn('id', $selected_permission)->groupBy('parent_name')->oldest('id')->get();
        }

        return view('admin.roles.create',compact('permissionParent'), ['page_title' => 'Add Role']);
    }

    public function store(Request $request){
        $this->validate($request, [
            'name'          => 'required|unique:roles,name',
            'permission'    => 'required',
        ]);
        $role = new Role;
        $role->name = $request->name;
        $role->guard_name = 'admin';
        $role->save();
        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.roles.index')->with('success','Role Created Successfully !!');
    }

    public function show($id){
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")->where("role_has_permissions.role_id",$id)->get();
        return view('admin.roles.show',compact('role','rolePermissions'), ['page_title'=>'Role Show']);
    }

    public function edit($id){
        $role = Role::find($id);

        if(Auth::guard('admin')->user()->id == 1){
            $permissionParent = Permission::groupBy('parent_name')->oldest('id')->get();
        }else{
            $roles_id = Auth::guard('admin')->user()->roles->pluck('id');
            $selected_permission = DB::table('role_has_permissions')->whereIn('role_id', $roles_id)->pluck('permission_id');
            $permissionParent = Permission::whereIn('id', $selected_permission)->groupBy('parent_name')->oldest('id')->get();
        }
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')->all();

        return view('admin.roles.edit',compact('role','rolePermissions', 'permissionParent'), ['page_title' => 'Update Role']);
    }

    public function update(Request $request, $id){
        $this->validate($request, [
            'name'          => 'required|unique:roles,name,'.$id,
            'permission'    => 'required',
        ]);

        $role = Role::find($id);
        $role->name = $request->name;
        $role->guard_name = 'admin';
        $role->save();

        $role->syncPermissions($request->input('permission'));

        return redirect()->route('admin.roles.index')->with('success','Role Updated Successfully !!');
    }

    public function destroy($id){
        Role::destroy($id);
        return redirect()->route('admin.roles.index')->with('success','Role Deleted Successfully !!');
    }

}
