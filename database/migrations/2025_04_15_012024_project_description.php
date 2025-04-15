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
        Schema::create('project_descriptions', function (Blueprint $table) {
            $table->id();

            // Use foreign key from projects_tbl
            $table->foreignId('project_id')
                  ->constrained('projects')
                  ->onDelete('cascade');
            
            $table->string('projectID'); // for external/public reference
            $table->text('ProjectDescription');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_descriptions');
    }
};
