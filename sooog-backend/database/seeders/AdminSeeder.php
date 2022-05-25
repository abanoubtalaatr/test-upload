<?php

namespace Database\Seeders;

use App\Admin\Domain\Models\Admin;
use Illuminate\Database\Seeder;
use App\Admin\Domain\Models\Role;
use App\Admin\Domain\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $admin = Admin::firstOrCreate(
            [
            'email' => 'super_admin@fudex.com.sa'
            ],
            [
                'name' => 'مدير النظام',
                'email' => "super_admin@fudex.com.sa",
                'phone' => '96655555555',
                'password' => bcrypt("password"),
                'is_active' => 1,
            ]
        );

        $role = Role::where('guard_name', 'admin')->where('name', 'super admin')->first();
        //$permissions = Permission::where('guard_name', 'admin')->pluck('id');
        if($role)
            $admin->syncRoles([$role->id]);
    }
}
