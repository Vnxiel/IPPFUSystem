<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // user_id
            $table->string('ofmis_id')->unique(); // External system ID
            $table->string('fullname');
            $table->string('position');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('role');
            $table->string('time_frame');
            $table->string('time_limit')->nullable();
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
