<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Location\Domain\Models\Country;
use App\Location\Domain\Models\State;
use App\Location\Domain\Models\City;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $countries = Country::all();

        foreach ($countries as $country) {
            $is_active = 0;
            if($country->iso2 == 'SA')
                $is_active = 1;

            foreach ($country->states as $state ) {
                $state->update([
                    'is_active' => $is_active
                ]);

                $state->cities()->update([
                    'is_active' => $is_active
                ]);
            }

            $country->update([
                'is_active' => $is_active
            ]);
        }
        
    }
}
