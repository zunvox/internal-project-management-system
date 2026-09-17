<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\PaymentVoucher;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentVoucherSampleSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Get sample users
        |--------------------------------------------------------------------------
        */

        $developer = User::where('role', 'Developer')->first();

        $admin = User::where('role', 'Admin')->first();

        if (! $developer || ! $admin) {
            $this->command->error(
                'You need at least one Developer and one Admin account first.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Get a project assigned to the developer
        |--------------------------------------------------------------------------
        */

        $project = Project::whereHas(
            'assignedUsers',
            function ($query) use ($developer) {
                $query->where('users.id', $developer->id);
            }
        )->first();

        if (! $project) {
            $this->command->error(
                'The Developer must be assigned to at least one project.'
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Sample 1 - Submitted
        |--------------------------------------------------------------------------
        */

        $invoice1 = Invoice::updateOrCreate(
            [
                'invoice_code' => 'INV-0231',
            ],
            [
                'user_id' => $developer->id,
                'project_id' => $project->id,

                'subject' => 'Website Development',
                'description' => 'Development work completed for the assigned project.',

                'status' => 'Submitted',

                'subtotal' => 850.00,
                'tax_amount' => 40.00,
                'discount_amount' => 0.00,
                'grand_total' => 890.00,

                'submitted_at' => now()->subDays(5),

                'reviewed_by' => null,
                'reviewed_at' => null,
                'review_notes' => null,
            ]
        );

        $invoice1->items()->delete();

        $invoice1->items()->createMany([
            [
                'item_name' => 'Frontend Development',
                'quantity' => 1,
                'unit_price' => 500.00,
                'total_price' => 500.00,
            ],
            [
                'item_name' => 'Backend Development',
                'quantity' => 1,
                'unit_price' => 350.00,
                'total_price' => 350.00,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sample 2 - Submitted
        |--------------------------------------------------------------------------
        */

        $invoice2 = Invoice::updateOrCreate(
            [
                'invoice_code' => 'INV-0230',
            ],
            [
                'user_id' => $developer->id,
                'project_id' => $project->id,

                'subject' => 'Software Maintenance',
                'description' => 'Minor software maintenance and bug fixing.',

                'status' => 'Submitted',

                'subtotal' => 65.50,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00,
                'grand_total' => 65.50,

                'submitted_at' => now()->subDays(8),

                'reviewed_by' => null,
                'reviewed_at' => null,
                'review_notes' => null,
            ]
        );

        $invoice2->items()->delete();

        $invoice2->items()->create([
            'item_name' => 'Bug Fixing',
            'quantity' => 1,
            'unit_price' => 65.50,
            'total_price' => 65.50,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sample 3 - Submitted
        |--------------------------------------------------------------------------
        */

        $invoice3 = Invoice::updateOrCreate(
            [
                'invoice_code' => 'INV-0228',
            ],
            [
                'user_id' => $developer->id,
                'project_id' => $project->id,

                'subject' => 'Database Configuration',
                'description' => 'Database configuration and optimization.',

                'status' => 'Submitted',

                'subtotal' => 340.50,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00,
                'grand_total' => 340.50,

                'submitted_at' => now()->subDays(12),

                'reviewed_by' => null,
                'reviewed_at' => null,
                'review_notes' => null,
            ]
        );

        $invoice3->items()->delete();

        $invoice3->items()->create([
            'item_name' => 'Database Configuration',
            'quantity' => 1,
            'unit_price' => 340.50,
            'total_price' => 340.50,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Sample 4 - Approved
        |--------------------------------------------------------------------------
        */

        $invoice4 = Invoice::updateOrCreate(
            [
                'invoice_code' => 'INV-0227',
            ],
            [
                'user_id' => $developer->id,
                'project_id' => $project->id,

                'subject' => 'API Integration',
                'description' => 'Integration of external API services.',

                'status' => 'Approved',

                'subtotal' => 1200.00,
                'tax_amount' => 60.00,
                'discount_amount' => 10.00,
                'grand_total' => 1250.00,

                'submitted_at' => now()->subDays(16),

                'reviewed_by' => $admin->id,
                'reviewed_at' => now()->subDays(14),

                'review_notes' => 'Invoice reviewed and approved.',
            ]
        );

        $invoice4->items()->delete();

        $invoice4->items()->createMany([
            [
                'item_name' => 'API Development',
                'quantity' => 2,
                'unit_price' => 400.00,
                'total_price' => 800.00,
            ],
            [
                'item_name' => 'API Integration',
                'quantity' => 1,
                'unit_price' => 400.00,
                'total_price' => 400.00,
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Payment Voucher for Approved Invoice
        |--------------------------------------------------------------------------
        */

        PaymentVoucher::updateOrCreate(
            [
                'invoice_id' => $invoice4->id,
            ],
            [
                'reviewed_by' => $admin->id,
                'claim_id' => null,

                'voucher_code' => 'PV-2026-0001',

                'amount' => $invoice4->grand_total,

                'payment_method' => 'Bank Transfer',

                'notes' => 'Payment to be processed through bank transfer.',

                'status' => 'Generated',

                'reviewed_at' => $invoice4->reviewed_at,
                'generated_at' => now()->subDays(13),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Sample 5 - Rejected
        |--------------------------------------------------------------------------
        */

        $invoice5 = Invoice::updateOrCreate(
            [
                'invoice_code' => 'INV-0226',
            ],
            [
                'user_id' => $developer->id,
                'project_id' => $project->id,

                'subject' => 'Equipment Purchase',
                'description' => 'Equipment purchase submitted for project work.',

                'status' => 'Rejected',

                'subtotal' => 540.00,
                'tax_amount' => 0.00,
                'discount_amount' => 0.00,
                'grand_total' => 540.00,

                'submitted_at' => now()->subDays(20),

                'reviewed_by' => $admin->id,
                'reviewed_at' => now()->subDays(18),

                'review_notes' => 'Supporting document does not match the submitted amount.',
            ]
        );

        $invoice5->items()->delete();

        $invoice5->items()->create([
            'item_name' => 'Project Equipment',
            'quantity' => 2,
            'unit_price' => 270.00,
            'total_price' => 540.00,
        ]);

        $this->command->info(
            'Payment Voucher sample data created successfully.'
        );
    }
}
