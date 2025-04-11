<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
            Schema::create('projectFiles_tbl', function (Blueprint $table) {
                $table->id();
                $table->string('projectID');
                $table->string('fileName');
                $table->string('fileID');
                $table->string('actionBy');
                $table->timestamps();

                $table->foreign('projectID')->references('projectID')->on('projects_tbl')->onDelete('cascade');
            });
    }

    public function down() {
        Schema::dropIfExists('projectFiles_tbl');
    }
};
