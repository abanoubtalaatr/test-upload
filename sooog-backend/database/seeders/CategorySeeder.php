<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Category\Domain\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
     //    Category::where('is_active', 1)->update(['image' => '1607346305_n0nY5Nre.jpg']);
      //Category::where('is_active', 0)->update(['image' => '1607346305_n0nY5Nre.jpg']);
      // Category::whereNotNull('parent_id')->update(['tax_percentage' => 20]);
      //   $categories = Category::whereNotNull('parent_id')->get();

      //   foreach($categories as $category){
      //       foreach($category->products()->get() as $product){
      //           $tax = $product->price * $category->tax_percentage / 100;
      //           $product->update([
      //               'price_including_tax' => $product->price + $tax
      //           ]);
      //       }
      //   }
        $categories = [
            [
                'ar'  => ['name' => 'الماس'],
                'en'  => ['name' => 'Diamond'],
                'is_active' => 1,
                'order' => 1,
                'parent_id' => NULL,
                'image' => '1607346305_n0nY5Nre.jpg',
                'type' => 'stores'

            ],
            [
                'ar'  => ['name' => 'ذهب'],
                'en'  => ['name' => 'Gold'],
                'is_active' => 1,
                'order' => 1,
                'parent_id' => NULL,
                'image' => '1607346305_n0nY5Nre.jpg',
                'type' => 'stores'

            ],
            [
                'ar'  => ['name' => 'فضة'],
                'en'  => ['name' => 'Silver'],
                'is_active' => 1,
                'order' => 1,
                'parent_id' => NULL,
                'image' => '1607346305_n0nY5Nre.jpg',
                'type' => 'centers'

            ],
            [
                'ar'  => ['name' => 'أحجار كريمة'],
                'en'  => ['name' => 'Gemstones'],
                'is_active' => 1,
                'order' => 1,
                'parent_id' => NULL,
                'image' => '1607346305_n0nY5Nre.jpg',
                'type' => 'centers'

            ],
            // [
            //     'ar'  => ['name' => 'ساعات'],
            //     'en'  => ['name' => 'Watches'],
            //     'is_active' => 1,
            //     'order' => 2,
            //     'parent_id' => 1,
            //     'image' => '1607346305_n0nY5Nre.jpg',
            //     'tax_percentage' => 20
            // ],
            // [
            //     'ar'  => ['name' => 'خواتم'],
            //     'en'  => ['name' => 'Rings'],
            //     'is_active' => 1,
            //     'order' => 2,
            //     'parent_id' => 1,
            //     'image' => '1607346305_n0nY5Nre.jpg',
            //     'tax_percentage' => 20
            // ],
            // [
            //     'ar'  => ['name' => 'ساعات'],
            //     'en'  => ['name' => 'Watches'],
            //     'is_active' => 1,
            //     'order' => 2,
            //     'parent_id' => 2,
            //     'image' => '1607346305_n0nY5Nre.jpg',
            //     'tax_percentage' => 20
            // ],
            // [
            //     'ar'  => ['name' => 'خواتم'],
            //     'en'  => ['name' => 'Rings'],
            //     'is_active' => 1,
            //     'order' => 2,
            //     'parent_id' => 2,
            //     'image' => '1607346305_n0nY5Nre.jpg',
            //     'tax_percentage' => 20
            // ],

        ];

        foreach ($categories as $category){
            Category::create($category);
        }
    }
}
