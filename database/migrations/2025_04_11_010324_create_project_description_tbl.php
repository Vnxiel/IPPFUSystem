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
        Schema::create('project_description_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('projectID')->unique();
            $table->text('ProjectDescription');
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
        Schema::dropIfExists('project_description_tbl');
    }
};
