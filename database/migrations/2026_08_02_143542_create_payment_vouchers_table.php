<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_vouchers', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('claim_id')
                ->nullable()
                ->constrained('claims')
                ->restrictOnDelete();

            $table->foreignId('invoice_id')
                ->nullable()
                ->constrained('invoices')
                ->restrictOnDelete();

            $table->string('voucher_code', 50)->unique();
            $table->decimal('amount', 12, 2);

            $table->enum('payment_method', [
                'Bank Transfer',
                'Cash',
                'Cheque',
                'Online Payment',
                'Other',
            ])->nullable();

            $table->text('notes')->nullable();

            $table->enum('status', [
                'Under Review',
                'Generated',
                'Paid',
                'Rejected',
            ])->default('Under Review');

            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('generated_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('generated_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_vouchers');
    }
};