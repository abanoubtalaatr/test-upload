<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\AppContent\Domain\Models\ContactType;
class ContactTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'ar'  => ['name' => 'شكوى'],
                'en'  => ['name' => 'Complain'],
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'طلب'],
                'en'  => ['name' => 'Request'],
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'اقتراح'],
                'en'  => ['name' => 'Suggestion'],
                'is_active' => 1

            ],
            [
                'ar'  => ['name' => 'أخرى'],
                'en'  => ['name' => 'Other'],
                'is_active' => 1

            ]
        ];

        foreach ($types as $type){
            ContactType::create($type);
        }
    }
}
