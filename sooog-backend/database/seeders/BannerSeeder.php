<?php

namespace Database\Seeders;

use App\Banner\Domain\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
            'image'=>'logo.png',
        ]);
    }
}
