<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Store\Domain\Models\Store;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //`email`, `phone`, `image`, `latitude`, `longitude`, `address`, `city_id`, `bank_name`, `iban_no`, `swift_code`, `bank_account_no`, `commercial_registry_no`, `commercial_registry_photo`, `status`, `is_active`, `deactivation_reason`, `rejection_reason`, `type`, `is_featured`, `delivery_charge
        $stores = [
            [
                'ar'  => ['name' => 'متجر 1'],
                'en'  => ['name' => 'store1'],
                'status' => 0,
                'image' => '',
                'email' => 'store1@fudex.com.sa',
                'phone' => 966512345678,
                'city_id' => 102805,
                'commercial_registry_no' => 1234,
                'commercial_registry_photo' => '',
                'type' => 'stores',
                'latitude' => 1212345678,
                'longitude' => 24.12365478,
                'address' => 'ryad',
                'bank_name' => 'alahly',
                'iban_no' => 12345,
                'swift_code' => 'Eg123456',
                'bank_account_no' => 121212121,
                'delivery_charge' => 50
            ],
//            [
//                'ar'  => ['name' => 'مركز خدمة 1'],
//                'en'  => ['name' => 'maintenance center1'],
//                'status' => 0,
//                'image' => '',
//                'email' => 'center1@fudex.com.sa',
//                'phone' => 966512345679,
//                'city_id' => 102804,
//                'commercial_registry_no' => 4321,
//                'commercial_registry_photo' => '',
//                'type' => 'centers',
//                'latitude' => 1212345678,
//                'longitude' => 24.12365478,
//                'address' => 'ryad',
//                'bank_name' => 'alahly',
//                'iban_no' => 12346,
//                'swift_code' => 'Eg123456',
//                'bank_account_no' => 121212120,
//                'delivery_charge' => 0
//            ]
        ];

        foreach ($stores as $store){
            Store::create($store);
        }
    }
}
