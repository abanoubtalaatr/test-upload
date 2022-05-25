<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            PermissionSeeder::class,
            AdminSeeder::class,
            StorePermissionSeeder::class,
            RoleSeeder::class,
            //CountrySeeder::class,
            //StateSeeder::class,
            //CityTableSeeder::class,
           // SACitySeeder::class,
            PaymentMethodSeeder::class,
            StoreSeeder::class,
            StatusSeeder::class,
            PropertyTypeSeeder::class,
            PageSeeder::class,
            SettingSeeder::class,
            ContactTypeSeeder::class,
            BannerSeeder::class,
//
            OnlinePaymentSeeder::class,

        PackageSeeder::class,
        ]);
    }
}
