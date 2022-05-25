<?php

namespace Database\Seeders;

use App\Location\Domain\Models\Country;
use App\User\Domain\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Constraint\Count;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::create([
            'is_active' => 1,
            'code' => '+20',
        ]);

        User::create([
            'name' => 'abanoub',
            'email' => 'abanoubtalaat555@gmail.com',
            'country_code' => "+20",
            'phone' => '1014636418',
            'phone_verified_at'  => now(),
            'is_active' => 1,
            'password' => Hash::make('password'),
        ]);

        $users = User::all();
        $data = [];
        foreach ($users as $user) {

            if(str_starts_with($user->phone, '0'))
                $data['phone'] = substr($user->phone,1,20);

            // if(!str_starts_with($user->country_code, '+'))
            //     $data['country_code'] = '+'.$user->country_code;

            if(count($data) > 0)
                $user->update($data);
        }

    }
}


