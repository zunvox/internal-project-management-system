<?php

namespace Database\Seeders;

use App\Models\CashFlowCategory;
use Illuminate\Database\Seeder;

class CashFlowCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [

            // Cash In
            [
                'category_name' => 'Client Payment',
                'cash_flow_type' => 'Cash In',
            ],
            [
                'category_name' => 'Project Payment',
                'cash_flow_type' => 'Cash In',
            ],
            [
                'category_name' => 'Service Income',
                'cash_flow_type' => 'Cash In',
            ],
            [
                'category_name' => 'Refund Received',
                'cash_flow_type' => 'Cash In',
            ],
            [
                'category_name' => 'Other Income',
                'cash_flow_type' => 'Cash In',
            ],

            // Cash Out
            [
                'category_name' => 'Staff Claims',
                'cash_flow_type' => 'Cash Out',
            ],
            [
                'category_name' => 'Office Supplies',
                'cash_flow_type' => 'Cash Out',
            ],
            [
                'category_name' => 'Internet & Utilities',
                'cash_flow_type' => 'Cash Out',
            ],
            [
                'category_name' => 'Software Subscription',
                'cash_flow_type' => 'Cash Out',
            ],
            [
                'category_name' => 'Equipment Purchase',
                'cash_flow_type' => 'Cash Out',
            ],
            [
                'category_name' => 'Travel Expense',
                'cash_flow_type' => 'Cash Out',
            ],
            [
                'category_name' => 'Maintenance',
                'cash_flow_type' => 'Cash Out',
            ],
            [
                'category_name' => 'Other Expense',
                'cash_flow_type' => 'Cash Out',
            ],

        ];

        foreach ($categories as $category) {

            CashFlowCategory::updateOrCreate(
                [
                    'category_name' => $category['category_name'],
                    'cash_flow_type' => $category['cash_flow_type'],
                ],
                [
                    'is_active' => true,
                ]
            );

        }
    }
}
