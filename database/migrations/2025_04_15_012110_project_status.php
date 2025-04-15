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
        Schema::create('project_statuses', function (Blueprint $table) {
            $table->increments('id');  // Auto-incrementing id
            $table->string('projectID')->unique();
         
            $table->date('date');
            $table->string('percentage');
            $table->string('progress'); // 0-100%
            $table->timestamps();

            $table->foreign('projectID')
                ->references('projectID')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_statuses');
    }
};
