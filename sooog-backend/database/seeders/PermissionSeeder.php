<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Admin\Domain\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // \Spatie\Permission\Models\Permission::create(['name'=>'posts.*']);
        // Reset cached roles and permissions
     //    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        // \DB::table('model_has_permissions')->truncate();
        // \DB::table('permissions')->truncate();
        //[alwaseetProducts, shippingCompanies, coupons, refunds, orders, userClasses, pointsSettings, receivedNotifications, sentNotifications, properties, contactUs[index, show, reply]]
        $crudPermissionNames = ['admins' => 'المدراء', 'roles' => 'الأدوار والصلاحيات', 'users' => 'المستخدمين', 'categories' => 'الأفسام', 'brands' => 'العلامات التجارية', 'products' => 'المنتجات', 'ads' => 'الإعلانات', 'offers' => 'العروض', 'pages' => 'الصفحات', 'promo_codes' => 'الرموز الترويجية', 'properties' => 'الحقول الإضافية', 'stores' => 'المتاجر', 'refund_reasons'=> 'أسباب الإرتجاع', 'orders'=> 'الطلبات', 'refunds' => 'المرتجعات', 'contact_us' => 'اتصل بنا', 'bank_accounts' => 'الحسابات البنكية', 'notifications' => 'الإشعارات', 'countries' => 'الدول', 'states' => 'المناطق', 'cities' => 'المدن', 'subcategories' => 'الأقسام الفرعية',  'services' => 'الخدمات', 'banners' => 'اللافتات', 'packages' => 'الباقات'];

        $crudActions = ['index' => 'تصفح', 'create' => 'إضافة', 'update' =>'تعديل', 'delete' => 'حذف' ];
        
        $permissions = [
            [
                'name' => 'statistics.index', 
                'key' => 'statistics', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'statistics.index', 'key_name' => 'statistics', 'key_name' => 'Statistics'], 
                'ar'  => ['display_name' => 'تصفح الاحصائيات', 'key_name' => 'الاحصائيات', 'key_name' => 'الإحصائيات']
            ],
            [
                'name' => 'settings.index', 
                'key' => 'settings', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'settings.index', 'key_name' => 'Settings'], 
                'ar'  => ['display_name' => 'تصفح وتعديل الاعدادات العامة', 'key_name' => 'الإعدادات']
            ],
            [
                'name' => 'comments.index', 
                'key' => 'comments', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'comments.index', 'key_name' => 'comments'], 
                'ar'  => ['display_name' => 'تصفح التعليقات', 'key_name' => 'التعليقات']
            ],
            [
                'name' => 'comments.update', 
                'key' => 'comments', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'accept&reject comments', 'key_name' => 'comments'], 
                'ar'  => ['display_name' => 'قبول ورفض التعلقات', 'key_name' => 'التعليقات']
            ],
            [
                'name' => 'pages.index', 
                'key' => 'pages', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'static pages.index', 'key_name' => 'pages'], 
                'ar'  => ['display_name' => 'تصفح ةتععديل الصفحات الثابتة', 'key_name' => 'الصفحات الثلبتة']
            ],
            [
                'name' => 'stores.featured', 
                'key' => 'stores', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'set featured stores', 'key_name' => 'stores'], 
                'ar'  => ['display_name' => 'تعيين المتاجر المتميزة', 'key_name' => 'المتاجر']
            ],
//            [
//                'name' => 'centers.featured',
//                'key' => 'centers',
//                'guard_name' => 'admin',
//                'en'  => ['display_name' => 'set featured centers', 'key_name' => 'centers'],
//                'ar'  => ['display_name' => 'تعيين مراكز الصيانة المتميزة', 'key_name' => 'مراكز الصيانة']
//            ],
            [
                'name' => 'users.transactions', 
                'key' => 'users', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'user transactions', 'key_name' => 'users'], 
                'ar'  => ['display_name' => 'معاملات المستخدمين', 'key_name' => 'المستخدمين']
            ],
            [
                'name' => 'payments.index', 
                'key' => 'payments', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'Payments.index', 'key_name' => 'payments'], 
                'ar'  => ['display_name' => 'مشاهدة المدفوعات', 'key_name' => 'المدفوعات']
            ],
            [
                'name' => 'financial_dues.index', 
                'key' => 'financial_dues', 
                'guard_name' => 'admin', 
                'en'  => ['display_name' => 'view financial dues', 'key_name' => 'financial_dues'], 
                'ar'  => ['display_name' => 'مشاهدة المستحقات المالية', 'key_name' => 'المستحقات المالية']
            ],
        ];
        foreach($permissions as $permission){
            Permission::updateOrCreate(
                [
                    'name' => $permission['name'], 
                    'key' => $permission['key'], 
                    'guard_name' => 'admin', 
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
                        'guard_name' => 'admin', 
                    ],
                    [
                        'en'  => ['display_name' => $en_action.' '.$en_permission, 'key_name' => $en_permission], 
                        'ar'  => ['display_name' => $ar_action.' '.$ar_permission, 'key_name' => $ar_permission]
                    ]
                );
            }
	    }

	    // $role = Role::create(['name' => 'super-admin']);
        //$role->givePermissionTo(Permission::all());

    }
}
