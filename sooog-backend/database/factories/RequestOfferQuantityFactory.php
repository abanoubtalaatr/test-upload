<?php

namespace Database\Factories;

use App\Category\Domain\Models\Category;
use App\Store\Domain\Models\Store;
use App\User\Domain\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RequestOfferQuantityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'store_id' => Store::factory(),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
            'image' => $this->faker->imageUrl(),
            'amount' => $this->faker->numberBetween(1,200),
            'details' => $this->faker->sentence(),
            'status' => $this->faker->randomElement(['Waiting', 'Replied', 'Accept', 'Delivered']),
            'offer_price' => $this->faker->sentence(),
        ];
    }
}
