<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{

    public function run(): void{
        $arrayAdmin = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@admin.dev',
                'password' => Hash::make(config('app.key')),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.dev',
                'password' => Hash::make('123456789'),
            ],
        ];

        $arrayRole = [
            [
                'name' => 'Super Admin',
                'guard_name' => 'admin'
            ],
            [
                'name' => 'Admin',
                'guard_name' => 'admin'
            ]
        ];

        foreach($arrayAdmin as $key=>$value) {
            $admin = Admin::updateOrCreate(['id'=>$key+1],$value);

            $role = Role::updateOrCreate(['id' => $key+1],$arrayRole[$key]);

            $permissions = Permission::pluck('id','id')->all();

            $role->syncPermissions($permissions);

            $admin->assignRole([$role->id]);
        }
    }
}
