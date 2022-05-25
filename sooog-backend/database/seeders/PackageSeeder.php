<?php

namespace Database\Seeders;

use App\Package\Domain\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'ar'  => ['name' => 'الباقة المجانية'],
                'en'  => ['name' => 'Free Package'],
                'months'  => 1,
                'price'  => 0,
                'image'  => 'logo.png',
                'product_number'  => 20,
                'order_number'  => 20,
                'has_chat'  => 0,
                'is_rfq'  => 0,
                'is_free'  => 1,
                'is_active' => 1

            ],
        ];

        foreach ($packages as $package){
            Package::updateOrCreate(
                [
//                    'is_free' => 1
                ],
                $package
            );
        }
    }
}
