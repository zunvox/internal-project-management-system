<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            $table->foreignId('project_id')
                ->constrained('projects')
                ->restrictOnDelete();

            $table->foreignId('category_id')
                ->constrained('claim_categories')
                ->restrictOnDelete();

            $table->string('claim_code', 50)->unique();
            $table->string('title', 200);
            $table->decimal('amount', 12, 2);

            $table->string('receipt');

            $table->enum('status', [
                'Submitted',
                'Approved',
                'Rejected',
            ])->default('Submitted');

            $table->text('description')->nullable();

            $table->timestamp('submitted_at');

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('submitted_at');
            $table->index([
                'user_id',
                'project_id',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};