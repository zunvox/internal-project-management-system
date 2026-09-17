<?php

namespace Database\Seeders;

use App\Models\ClaimCategory;
use Illuminate\Database\Seeder;

class ClaimCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'category_name' => 'Travel',
                'description' => 'Transportation, fuel, toll, parking and other work-related travel expenses.',
                'is_active' => true,
            ],

            [
                'category_name' => 'Meals',
                'description' => 'Work-related meal and refreshment expenses.',
                'is_active' => true,
            ],

            [
                'category_name' => 'Accommodation',
                'description' => 'Hotel and accommodation expenses for work-related travel.',
                'is_active' => true,
            ],

            [
                'category_name' => 'Office Supplies',
                'description' => 'Work-related stationery, equipment and office supplies.',
                'is_active' => true,
            ],

            [
                'category_name' => 'Software & Services',
                'description' => 'Software, subscriptions and online services required for project work.',
                'is_active' => true,
            ],

            [
                'category_name' => 'Other',
                'description' => 'Other valid work-related expenses that do not fall under another category.',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {

            ClaimCategory::updateOrCreate(
                [
                    'category_name' => $category['category_name'],
                ],
                [
                    'description' => $category['description'],
                    'is_active' => $category['is_active'],
                ]
            );

        }
    }
}
