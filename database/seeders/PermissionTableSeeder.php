<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [

            'dashboard',

            'user-index',
            'user-create',
            'user-edit',
            'user-verify',
            'user-block',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'staff-list',
            'staff-create',
            'staff-edit',
            'staff-delete',
        ];

        $routes = [

            'admin.dashboard',

            'admin.users.index',
            'admin.users.index',
            'admin.users.index',
            'admin.users.index',
            'admin.users.index',

            'admin.roles.index',
            'admin.roles.index',
            'admin.roles.index',
            'admin.roles.index',

            'admin.staffs.index',
            'admin.staffs.index',
            'admin.staffs.index',
            'admin.staffs.index',
        ];

        foreach ($permissions as $key=>$permission) {
            $data=explode('-',$permission);

            $permissions_data = Permission::where('name', $permission)->first();
            if(!$permissions_data){
                $permissions_data = new Permission;
            }
            $permissions_data->name=$permission;
            $permissions_data->parent_name=$data[0];
            $permissions_data->guard_name = 'admin';
            $permissions_data->route_name = $routes[$key];
            $permissions_data->save();
        }
    }
}
