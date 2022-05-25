<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Admin\Domain\Models\Permission;
use App\Admin\Domain\Models\Role;
use App\Admin\Domain\Models\Admin;
use App\Store\Domain\Models\CenterAdmin;


class CenterPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $crudPermissionNames = ['admins' => 'المدراء', 'roles' => 'الأدوار والصلاحيات', 'services' => 'الخدمات', 'orders' => 'الطلبات'];

        $crudActions = ['index' => 'تصفح', 'create' => 'إضافة', 'update' =>'تعديل', 'delete' => 'حذف' ];
        
        $permissions = [
            [
                'name' => 'statistics.index', 
                'key' => 'statistics', 
                'guard_name' => 'center', 
                'en'  => ['display_name' => 'statistics.index', 'key_name' => 'statistics', 'key_name' => 'Statistics'], 
                'ar'  => ['display_name' => 'تصفح الاحصائيات', 'key_name' => 'الاحصائيات', 'key_name' => 'الإحصائيات']
            ],
            // [
            //     'name' => 'settings.index', 
            //     'key' => 'settings', 
            //     'guard_name' => 'store', 
            //     'en'  => ['display_name' => 'settings.index', 'key_name' => 'Settings'], 
            //     'ar'  => ['display_name' => 'تصفح وتعديل الاعدادات العامة', 'key_name' => 'الإعدادات']
            // ]
        ];
        foreach($permissions as $permission){
            Permission::updateOrCreate(
                [
                    'name' => $permission['name'], 
                    'key' => $permission['key'], 
                    'guard_name' => 'center', 
                ],
                [
                    'en'  => $permission['en'], 
                    'ar'  => $permission['ar']
                ]
            );
        }

	    foreach($crudPermissionNames as $en_permission => $ar_permission){
            foreach($crudActions as $en_action => $ar_action){
                Permission::updateOrCreate(
                    [
                        'name' => $en_permission.'.'.$en_action, 
                        'key' => $en_permission, 
                        'guard_name' => 'center', 
                    ],
                    [
                        'en'  => ['display_name' => $en_action.' '.$en_permission, 'key_name' => $en_permission], 
                        'ar'  => ['display_name' => $ar_action.' '.$ar_permission, 'key_name' => $ar_permission]
                    ]
                );
            }
	    }

        $permissions = Permission::where('guard_name', 'center')->pluck('id');
        $role = Role::firstOrCreate(
            [
            'name' => 'super admin',
            'guard_name' => 'center'
            ],[
            'name' => 'super admin',
            'guard_name' => 'center', 
            'en'  => ['display_name' => 'super admin'], 
            'ar'  => ['display_name' => 'المدير العام']
        ]);
        $role->givePermissionTo($permissions);
        $admins = CenterAdmin::whereNotNull('store_id')->get();
        foreach ($admins as $admin) {
            if($admin->store->type == 'centers')
                $admin->syncRoles($role);
        }

    }
}
