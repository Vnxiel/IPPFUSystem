<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('project_status', function (Blueprint $table) {
            $table->increments('id');  // Auto-incrementing id
            $table->string('projectID');
            $table->date('date');
            $table->string('percentage');
            $table->string('progress'); // 0-100%
            $table->timestamps();

            $table->foreign('projectID')
                ->references('projectID')
                ->on('projects_tbl')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('project_status');
    }
};
