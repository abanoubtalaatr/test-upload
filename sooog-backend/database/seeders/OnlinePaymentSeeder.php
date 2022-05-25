<?php

namespace Database\Seeders;

use App\Order\Domain\Models\OnlinePaymentMethod;
use Illuminate\Database\Seeder;

class OnlinePaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $methods = [
            [
                'ar'  => ['name' => 'فيزا'],
                'en'  => ['name' => 'VISA'],
                'index' => 'VISA',
                'image' => 'VISA.png',
                'is_active' => 1,
                'status' => 1,

            ],[
                'ar'  => ['name' => 'ماستر كارت'],
                'en'  => ['name' => 'MASTER CARD'],
                'index' => 'MASTER',
                'image' => 'MASTERDEBIT.png',
                'is_active' => 1,
                'status' => 1,

            ],[
                'ar'  => ['name' => 'مدى'],
                'en'  => ['name' => 'MADA'],
                'index' => 'MADA',
                'image' => 'MADA.png',
                'is_active' => 1,
                'status' => 1,

            ],[
                'ar'  => ['name' => 'أبل باي'],
                'en'  => ['name' => 'APPLE PAY'],
                'index' => 'APPLEPAY',
                'image' => 'APPLEPAY.png',
                'is_active' => 0,
                'status' => 0,

            ],[
                'ar'  => ['name' => 'اس تي سي باي'],
                'en'  => ['name' => 'STC PAY'],
                'index' => 'STC_PAY',
                'image' => 'STC_PAY.png',
                'is_active' => 0,
                'status' => 0,
            ]
        ];

        foreach ($methods as $method){
            OnlinePaymentMethod::updateOrCreate(
                [
                    'index' => $method['index']
                ],
                $method
            );
        }

    }
}
