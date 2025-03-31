<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users_tbl', function (Blueprint $table) {
            $table->id();
            $table->string('ofmis_id')->nullable()->unique(); // Ensure ofmis_id is UNIQUE
            $table->string('fullname');
            $table->string('position');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('time_frame');
            $table->string('timeLimit')->nullable();
            $table->string('temp_role')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
