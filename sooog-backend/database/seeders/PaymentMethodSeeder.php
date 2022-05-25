<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Order\Domain\Models\PaymentMethod;
class PaymentMethodSeeder extends Seeder
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
                'ar'  => ['name' => 'الدفع عند الاستلام'],
                'en'  => ['name' => 'Cash On Delivery'],
                'type' => 'cash_on_delivery',
                'is_active' => 0

            ],
            [
                'ar'  => ['name' => 'دفع الكترونى'],
                'en'  => ['name' => 'Online Payment'],
                'type' => 'online',
                'is_active' => 1
            ],
            [
                'ar'  => ['name' => 'تحويل بنكى'],
                'en'  => ['name' => 'Bank Transfer'],
                'type' => 'bank_transfer',
                'is_active' => 1
            ],
            [
                'ar'  => ['name' => 'المحفظة'],
                'en'  => ['name' => 'Wallet'],
                'type' => 'wallet',
                'is_active' => 1
            ]
        ];

        foreach ($methods as $method){
            PaymentMethod::updateOrCreate(
                [
                    'type' => $method['type']
                ],
                $method
            );
        }

    }
}
