<?php

namespace Database\Seeders;

use App\Order\Domain\Models\Order;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $orders = Order::all();
        foreach ($orders as $order) {
            $data['application_dues_percentage'] = $order->store->application_dues > 0 ? $order->store->application_dues: setting('application_dues');
                if($data['application_dues_percentage'])
                    $data['application_dues'] = $order->total * $data['application_dues_percentage'] / 100;

                $data['store_has_delivery_service'] = $order->store->has_delivery_service;
                if($order->store->has_delivery_service != 1 )
                    $data['application_dues'] = $data['application_dues'] + $order->delivery_charge;

            $order->update($data);
        }
        
    }
}


