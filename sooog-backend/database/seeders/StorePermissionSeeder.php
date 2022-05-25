<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Admin\Domain\Models\Permission;
use App\Admin\Domain\Models\Role;
use App\Admin\Domain\Models\Admin;
use App\Store\Domain\Models\StoreAdmin;

class StorePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $crudPermissionNames = ['admins' => 'المدراء', 'roles' => 'الأدوار والصلاحيات', 'products' => 'المنتجات', 'promo_codes' => 'الرموز التويجية', 'offers' => 'العروض', 'orders'=> 'الطلبات', 'refunds' => 'المرتجعات'];

        $crudActions = ['index' => 'تصفح', 'create' => 'إضافة', 'update' =>'تعديل', 'delete' => 'حذف' ];
        
        $permissions = [
            [
                'name' => 'statistics.index', 
                'key' => 'statistics', 
                'guard_name' => 'store', 
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
                    'guard_name' => 'store', 
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
                        'guard_name' => 'store', 
                    ],
                    [
                        'en'  => ['display_name' => $en_action.' '.$en_permission, 'key_name' => $en_permission], 
                        'ar'  => ['display_name' => $ar_action.' '.$ar_permission, 'key_name' => $ar_permission]
                    ]
                );
            }
	    }

        $permissions = Permission::where('guard_name', 'store')->pluck('id');
        $role = Role::firstOrCreate(
            [
            'name' => 'super admin',
            'guard_name' => 'store'
            ],[
            'name' => 'super admin',
            'guard_name' => 'store', 
            'en'  => ['display_name' => 'super admin'], 
            'ar'  => ['display_name' => 'المدير العام']
        ]);
        $role->givePermissionTo($permissions);
        $admins = StoreAdmin::whereNotNull('store_id')->get();
        foreach ($admins as $admin) {
            if($admin->store->type == 'stores')
                $admin->syncRoles($role);
        }

    }
}
