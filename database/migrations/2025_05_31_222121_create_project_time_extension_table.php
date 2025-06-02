<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
{
    Schema::create('project_time_extension', function (Blueprint $table) {
        $table->id();

        // Foreign key reference to projects.id
        $table->foreignId('project_id')
              ->constrained('projects')
              ->onDelete('cascade');

        $table->string('time_extension_no'); // No longer unique on its own
        $table->text('time_extension_reason')->nullable();
        $table->text('time_extension')->nullable();
        $table->text('new_target_completion_date')->nullable();
        $table->date('revised_expiry')->nullable();
        $table->text('revised_expiry_reason')->nullable();
        $table->integer('total_extension_granted')->nullable(); // in days
        $table->integer('total_revised_contract_time')->nullable(); // in days
        $table->timestamps();

        // Composite unique constraint
        $table->unique(['project_id', 'time_extension_no'], 'project_time_extension_project_id_time_extension_no_unique');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_time_extension');
    }
};
