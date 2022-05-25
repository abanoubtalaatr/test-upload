<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\AppContent\Domain\Models\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'slug' => 'terms',
                'target' => 'admin',
                'created_by'       => 1,
                'ar'  => ['title' => 'ar terms and Conditions', 'body' => 'ar terms and cond.'],
                'en'  => ['title' => 'terms and Conditions', 'body' => 'terms and cond.'],
            ],
            [
                'slug' => 'about-us',
                'target' => 'admin',
                'created_by'          => 1,
                'ar'  => ['title' => 'ar about us', 'body' => 'ar about us body'],
                'en'  => ['title' => 'about us', 'body' => 'about us body'],
            ],
            [
                'slug' => 'refund-policy',
                'target' => 'admin',
                'created_by'          => 1,
                'ar'  => ['title' => 'arefund-policy', 'body' => 'ar refund-policy'],
                'en'  => ['title' => 'refund-policy', 'body' => 'en refund-policy'],
            ],
            [
                'slug' => 'policy',
                'target' => 'admin',
                'created_by'          => 1,
                'ar'  => ['title' => 'policy', 'body' => 'ar policy'],
                'en'  => ['title' => 'policy', 'body' => 'en policy'],
            ],
            [
                'slug' => 'refund-policy',
                'target' => 'admin',
                'created_by'          => 1,
                'ar'  => ['title' => 'refund policy', 'body' => 'ar refund policy'],
                'en'  => ['title' => 'refund policy', 'body' => 'en refund policy'],
            ]
        ];

        foreach ($pages as $page){
            Page::updateOrCreate(
                ['slug' => $page['slug']],
                $page
            );

        }
    }
}
