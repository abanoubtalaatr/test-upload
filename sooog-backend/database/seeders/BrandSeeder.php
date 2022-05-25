<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Brand\Domain\Models\Brand;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'ar'  => ['name' => 'داماس'],
                'en'  => ['name' => 'Damas'],
                'is_active' => 1,
                'image' => '',

            ],
            [
                'ar'  => ['name' => 'زهرة'],
                'en'  => ['name' => 'Flower'],
                'is_active' => 1,
            ]
        ];

        foreach ($brands as $brand){
            Brand::create($brand);
        }
    }
}
