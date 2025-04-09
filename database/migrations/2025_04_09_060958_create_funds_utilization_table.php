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
        Schema::create('funds_utilization_tbl', function (Blueprint $table) {
            $table->id();
        
            // Use string or unsignedBigInteger depending on your projects_tbl
            $table->string('projectID');
        
            // Original Values
            $table->decimal('orig_abc', 15, 2)->nullable();
            $table->decimal('orig_contract_amount', 15, 2)->nullable();
            $table->decimal('orig_engineering', 15, 2)->nullable();
            $table->decimal('orig_mqc', 15, 2)->nullable();
            $table->decimal('orig_bid', 15, 2)->nullable();
            $table->decimal('orig_appropriation', 15, 2)->nullable();
            $table->date('orig_completion_date')->nullable();
        
            // Actual Values
            $table->decimal('actual_abc', 15, 2)->nullable();
            $table->decimal('actual_contract_amount', 15, 2)->nullable();
            $table->decimal('actual_engineering', 15, 2)->nullable();
            $table->decimal('actual_mqc', 15, 2)->nullable();
            $table->decimal('actual_bid', 15, 2)->nullable();
            $table->decimal('actual_contingency', 15, 2)->nullable();
            $table->decimal('actual_appropriation', 15, 2)->nullable();
            $table->date('actual_completion_date')->nullable();
        
            $table->timestamps();
        
            // Foreign key to projects_tbl
            $table->foreign('projectID')
                ->references('projectID')
                ->on('projects_tbl')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
        
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds_utilization_tbl');
    }
    
};
