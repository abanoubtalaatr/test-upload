<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Order\Domain\Models\Status;
class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'ar'  => ['name' => 'جديد'],
                'en'  => ['name' => 'new'],
                'key' => 'new',
                'type' => 'order',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'مرفوض'],
                'en'  => ['name' => 'rejected'],
                'key' => 'rejected',
                'type' => 'order',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'ملغى'],
                'en'  => ['name' => 'canceled'],
                'key' => 'canceled',
                'type' => 'order',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'جارى التجهيز'],
                'en'  => ['name' => 'Preparation in progress'],
                'key' => 'accepted',
                'type' => 'order',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'جاهز على التوصيل'],
                'en'  => ['name' => 'Ready for delivery'],
                'key' => 'ready_for_delivery',
                'type' => 'order',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'جارى التوصيل'],
                'en'  => ['name' => 'Delivery in progress'],
                'key' => 'delivering',
                'type' => 'order',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'تم التوصيل'],
                'en'  => ['name' => 'delivered'],
                'key' => 'delivered',
                'type' => 'order',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'جديد'],
                'en'  => ['name' => 'new'],
                'key' => 'new',
                'type' => 'refund',
                'is_active' => 1
            ],
            [
                'ar'  => ['name' => 'مرفوض'],
                'en'  => ['name' => 'rejected'],
                'key' => 'rejected',
                'type' => 'refund',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'مقبول'],
                'en'  => ['name' => 'accepted'],
                'key' => 'accepted',
                'type' => 'refund',
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'تم إرسال بديل'],
                'en'  => ['name' => 'A replacement has been sent'],
                'key' => 'replaced',
                'type' => 'refund',
                'is_active' => 1

            ],
        ];

        foreach ($statuses as $status){
            Status::updateOrCreate(
                [
                    'key' => $status['key'],
                    'type' => $status['type']
                ],
                $status
            );
        }
    }
}
