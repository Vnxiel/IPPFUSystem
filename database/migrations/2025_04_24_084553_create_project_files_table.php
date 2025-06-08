<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('project_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_id');
            $table->string('action_by');
            $table->text('file_path');
            $table->timestamps();
        });
        
    }

    public function down() {
        Schema::dropIfExists('project_files');
    }
};
