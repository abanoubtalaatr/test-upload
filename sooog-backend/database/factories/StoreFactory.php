<?php

namespace Database\Factories;

use App\Store\Domain\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class StoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Store::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                'ar'  => ['name' =>$this->faker->name()],
                'en'  => ['name' => Str::random(10)],
                'status' => 1,
                'is_active' => 1,
                'image' => '',
                'email' => 'store1@fudex.com.sa',
                'phone' => 966512345678,
                'city_id' => 104774,
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
        ];
    }
}
