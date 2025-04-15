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
        Schema::create('variation_orders', function (Blueprint $table) {
            $table->id();

            // Reference to funds_utilization table (foreign key)
            $table->foreignId('funds_utilization_id')
                ->constrained('funds_utilization')
                ->onDelete('cascade');

            // Variation Order Fields
            $table->decimal('vo_abc', 15, 2)->nullable();
            $table->decimal('vo_contract_amount', 15, 2)->nullable();
            $table->decimal('vo_engineering', 15, 2)->nullable();
            $table->decimal('vo_mqc', 15, 2)->nullable();
            $table->decimal('vo_contingency', 15, 2)->nullable();
            $table->decimal('vo_appropriation', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variation_orders');
    }
};
