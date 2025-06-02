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
        Schema::create('funds_breakdowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('funds_utilization_id')->constrained('funds_utilization')->onDelete('cascade');
            $table->string('name');
            $table->string('type');
            $table->string('month');
            $table->date('date_from');
            $table->date('date_to');
            $table->decimal('amount', 15, 2);
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('funds_breakdowns');
    }
};
