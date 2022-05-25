<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Property\Domain\Models\PropertyType;

class PropertyTypeSeeder extends Seeder
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
                'ar'  => ['name' => 'راديو'],
                'en'  => ['name' => 'radio'],
                'is_active' => 1,
                'has_options' => 1,
                'key' => 'radio',
            ],
            [
                'ar'  => ['name' => 'تحديد'],
                'en'  => ['name' => 'checkbox'],
                'is_active' => 1,
                'has_options' => 1,
                'key' => 'checkbox',
            ],
            [
                'ar'  => ['name' => 'نص'],
                'en'  => ['name' => 'text'],
                'is_active' => 1,
                'has_options' => 0,
                'key' => 'text',
            ],
            [
                'ar'  => ['name' => 'اختيار'],
                'en'  => ['name' => 'select'],
                'is_active' => 1,
                'has_options' => 1,
                'key' => 'select',
            ],
            [
                'ar'  => ['name' => 'اختيار متعدد'],
                'en'  => ['name' => 'multiple_select'],
                'is_active' => 0,
                'has_options' => 1,
                'key' => 'multible_select',
            ],
            [
                'ar'  => ['name' => 'رقم صحيح'],
                'en'  => ['name' => 'Integer Number'],
                'is_active' => 1,
                'has_options' => 0,
                'key' => 'number',
            ],
            [
                'ar'  => ['name' => 'رقم عشرى'],
                'en'  => ['name' => 'Decimal'],
                'is_active' => 1,
                'has_options' => 0,
                'key' => 'decimal',
            ],
            [
                'ar'  => ['name' => 'ملف'],
                'en'  => ['name' => 'file'],
                'is_active' => 0,
                'has_options' => 0,
                'key' => 'file',
            ],
        ];

        foreach ($types as $type){
            PropertyType::updateOrCreate(
                ['key' => $type['key']],
                $type
            );
        }
    }
}
