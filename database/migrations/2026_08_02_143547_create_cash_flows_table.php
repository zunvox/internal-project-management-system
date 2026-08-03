<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_flows', function (Blueprint $table) {
            $table->id();

            $table->foreignId('logged_by')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('flowcategory_id')
                ->constrained('cash_flow_categories')
                ->restrictOnDelete();

            $table->string('transaction_code', 50)->unique();

            $table->enum('type', [
                'Cash In',
                'Cash Out',
            ]);

            $table->string('subject', 200);
            $table->date('transaction_date');
            $table->decimal('amount', 12, 2);
            $table->text('description')->nullable();

            $table->timestamps();

            $table->index('type');
            $table->index('transaction_date');
            $table->index([
                'flowcategory_id',
                'transaction_date',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_flows');
    }
};