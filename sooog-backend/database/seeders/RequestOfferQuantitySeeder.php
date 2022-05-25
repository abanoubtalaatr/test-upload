<?php

namespace Database\Seeders;

use App\RequestOfferQuantity\Domain\Models\RequestOfferQuantity;
use Illuminate\Database\Seeder;

class RequestOfferQuantitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RequestOfferQuantity::factory()->count(10)->create();
    }
}
