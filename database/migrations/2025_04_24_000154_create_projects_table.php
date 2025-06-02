<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('projectID'); // External/public identifier

            $table->string('title');
            $table->string('location');

            $table->string('firm_name');
            $table->string('source_of_funds');
            $table->string('otherFund')->nullable();
            $table->string('mode_of_implementation');
            $table->integer('contract_days');
            $table->integer('year');
            $table->string('responsibility_center');
            $table->string('fpp');
            $table->string('actual_length')->nullable();


            $table->date('official_starting_date');
            $table->date('target_completion_date');
            $table->string('timeExtension')->nullable();
            $table->date('revisedTargetCompletion')->nullable();
            $table->date('actual_completion_date')->nullable();

            $table->date('revised_target_date')->nullable();
            $table->date('revisedCompletionDate')->nullable();
            $table->date('noa_issued_date')->nullable();
            $table->date('noa_received_date')->nullable();
            $table->date('ntp_issued_date')->nullable();
            $table->date('ntp_received_date')->nullable();

            $table->string('project_slippage')->nullable();
            $table->string('total_expenditure')->nullable();
            $table->string('engineer_name')->nullable();
            $table->string('engineer_position')->nullable();
            $table->string('contractor_name')->nullable();
            $table->string('contractor_address')->nullable();
            $table->string('physical_status')->nullable();
            $table->string('ongoing_status')->nullable();
            $table->string('reason_for_suspension')->nullable();
            $table->boolean('is_hidden')->default(false); // Better as boolean

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
