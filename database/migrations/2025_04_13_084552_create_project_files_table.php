<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('fileName');
            $table->string('fileID');
            $table->string('actionBy');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('projectFiles_tbl');
    }
};
