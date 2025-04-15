<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('project_statuses', function (Blueprint $table) {
            $table->increments('id');  // Auto-incrementing id
            $table->string('project_id');
            $table->date('date');
            $table->string('percentage');
            $table->string('progress'); // 0-100%
            $table->timestamps();

        });
    }

    public function down(): void {
        Schema::dropIfExists('project_statuses');
    }
};
