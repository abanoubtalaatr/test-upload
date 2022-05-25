<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\AppContent\Domain\Models\Setting;
use App\Property\Domain\Models\PropertyType;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $text_prop = PropertyType::where('key', 'text')->first();
        $no_prop = PropertyType::where('key', 'number')->first();
        $decimal_prop = PropertyType::where('key', 'decimal')->first();
        $radio_prop = PropertyType::where('key', 'radio')->first();
        $multible_select_prop = PropertyType::where('key', 'multible_select')->first();
        $select_prop = PropertyType::where('key', 'select')->first();
        $image_prop = PropertyType::where('key', 'image')->first();

        $settings = [
            [
                'ar'  => ['name' => 'نسبة مستحقات التطبيق من المبيعات'],
                'en'  => ['name' => 'Application Dues percentage from sales'],
                'target' => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'=> 'application_dues',
                'body'=> '5',
            ],
            [
                'ar'  => ['name' => 'قيمة الضريبة المضافة'],
                'en'  => ['name' => 'Added tax value'],
                'target' => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'=> 'added_tax',
                'body'=> '5',
                'is_active' => 0
            ],
            [
                'ar'  => ['name' => 'أقل سعر للطلب'],
                'en'  => ['name' => 'the minimum amount for order'],
                'property_type_id' => $decimal_prop->id,
                'key'=> 'order_min_cost',
                'target' => 'superAdmin',
                'body'=> '500',
            ],
            [
                'ar'  => ['name' => 'عدد الأيام المسموح بها للإسترجاع'],
                'en'  => ['name' => 'the allowed numer of days for refund'],
                'property_type_id' => $no_prop->id,
                'key'=> 'refund_period',
                'target' => 'superAdmin',
                'body'=> '14',
            ],
            [
                'ar'  => ['name' => 'تكلفة التوصيل والتركيب'],
                'en'  => ['name' => 'Delivery and installation cost'],
                'target' => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'=> 'delivery_charge',
                'body'=> '500',
            ],
            [
                'ar'  => ['name' => 'قيمة الضريبة المضافة على سعر الطلب'],
                'en'  => ['name' => 'order Added tax value'],
                'target' => 'superAdmin',
                'property_type_id' => $decimal_prop->id,
                'key'=> 'order_added_tax',
                'body'=> '5',
            ],
            [
                'ar'  => ['name' => 'إمكانية التقييم والتعليق على المنتجات'],
                'en'  => ['name' => 'the ability of evaluating and commenting on products'],
                'target' => 'superAdmin',
                'property_type_id' => $radio_prop->id,
                'key'=> 'can_rate',
                'body'=> true,
            ],
            // [
            //     'ar'  => ['name' => 'cart_products_max_period'],
            //     'en'  => ['name' => 'cart_products_max_period'],
            //     'target' => 'superAdmin',
            //     'property_type_id' => $no_prop->id,
            //     'key'=> 'cart_products_max_period',
            //     'body'=> '14',
            // ],
            [
                'ar'  => ['name' => 'واتساب'],
                'en'  => ['name' => 'whatsapp'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'whatsapp',
                'body' => '0096612345678'
            ],
            [
                'ar'  => ['name' => 'تويتر'],
                'en'  => ['name' => 'twitter'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'twitter',
                'body' => 'twitter.com'
            ],
            [
                'ar'  => ['name' => 'انستاجرام'],
                'en'  => ['name' => 'instagram'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'instagram',
                'body' => 'instagram.com'
            ],
            [
                'ar'  => ['name' => 'فيسبوك'],
                'en'  => ['name' => 'facebook'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'facebook',
                'body' => 'facebook.com'
            ],
            [
                'ar'  => ['name' => 'الهاتف'],
                'en'  => ['name' => 'phone'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'phone',
                'body' => '966512365478'
            ],
            [
                'ar'  => ['name' => 'البريد الإلكترونى'],
                'en'  => ['name' => 'email'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'email',
                'body' => 'info@mokayiefy.com'
            ],
            [
                'ar'  => ['name' => 'رابط التطبيق على جوجل ستور'],
                'en'  => ['name' => 'application link on google store'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'google_store',
                'body' => 'googlestore.com'
            ],
            [
                'ar'  => ['name' => 'رابط التطبيق على أبل ستور'],
                'en'  => ['name' => 'application link on apple store'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'apple_store',
                'body' => 'applestore.com'
            ],
            [
                'ar'  => ['name' => 'يوتيوب'],
                'en'  => ['name' => 'Youtube'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'youtube',
                'body' => 'youtube.com'
            ],
            [
                'ar'  => ['name' => 'ملاحظات صور المنتج بالعربى'],
                'en'  => ['name' => 'product photos notes in Arabic'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'product_photos_notes_ar',
                'body' => 'يجب ان يكون ول الصورة 150 والعرض 200'
            ],
            [
                'ar'  => ['name' => 'ملاحظات صور المنتج  بالانجليزى'],
                'en'  => ['name' => 'product photos notes in English'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'product_photos_notes_en',
                'body' => 'photo width should be 200'
            ],[
                'ar'  => ['name' => ' اقرار الموافقة علي التسوق بالعربى'],
                'en'  => ['name' => 'Endorsement of confirmation on shopping in Arabic'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'shopping_confirmation_ar',
                'body'=> 'اقر علي الموافقة بالتسوق',
            ], [
                'ar'  => ['name' => ' اقرار الموافقة علي التسوق بالانجليزى'],
                'en'  => ['name' => 'Endorsement of confirmation on shopping in English'],
                'target' => 'superAdmin',
                'property_type_id' => $text_prop->id,
                'key'=> 'shopping_confirmation_en',
                'body'=> 'Accept Shopping',
            ],

        ];

        foreach ($settings as $setting){
            Setting::updateOrCreate(
                [
                    'key' => $setting['key'],
                    'target' => $setting['target']
                ],
                $setting
            );
        }
    }
}
