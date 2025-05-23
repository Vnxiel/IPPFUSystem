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

            $table->string('projectTitle');
            $table->string('projectLoc');

            $table->string('projectContractor');
            $table->string('sourceOfFunds');
            $table->string('otherFund')->nullable();
            $table->string('modeOfImplementation');
            $table->integer('projectContractDays');
            $table->integer('projectYear');
            $table->string('projectRC');
            $table->string('projectFPP');


            $table->date('originalStartDate');
            $table->date('targetCompletion');
            $table->string('timeExtension')->nullable();
            $table->date('revisedTargetCompletion')->nullable();
            $table->date('completionDate')->nullable();

            $table->date('revisedTargetDate')->nullable();
            $table->date('revisedCompletionDate')->nullable();
            $table->date('noaIssuedDate')->nullable();
            $table->date('noaReceivedDate')->nullable();
            $table->date('ntpIssuedDate')->nullable();
            $table->date('ntpReceivedDate')->nullable();

            $table->string('projectSlippage')->nullable();
            $table->string('totalExpenditure')->nullable();
            $table->string('ea')->nullable();
            $table->string('ea_position')->nullable();
            $table->string('othersContractor')->nullable();
            $table->string('projectStatus')->nullable();
            $table->string('ongoingStatus')->nullable();
            $table->string('suspensionRemarks')->nullable();
            $table->boolean('is_hidden')->default(false); // Better as boolean

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
