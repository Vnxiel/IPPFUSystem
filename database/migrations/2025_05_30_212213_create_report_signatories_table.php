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
        Schema::create('report_signatories', function (Blueprint $table) {
            $table->id();

            // Foreign key reference to projects.id
            $table->foreignId('project_id')
                  ->unique()
                  ->constrained('projects')
                  ->onDelete('cascade');

            $table->string('reviewed_by')->nullable();
            $table->string('noted_by')->nullable();
            $table->string('reviewed_by_position')->nullable();
            $table->string('noted_by_position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_signatories');
    }
};
