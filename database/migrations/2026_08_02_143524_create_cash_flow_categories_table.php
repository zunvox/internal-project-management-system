<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cash_flow_categories', function (Blueprint $table) {
            $table->id();

            $table->string('category_name', 100);

            $table->enum('cash_flow_type', [
                'Cash In',
                'Cash Out',
            ]);

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique([
                'category_name',
                'cash_flow_type',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cash_flow_categories');
    }
};