<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('projects_tbl', function (Blueprint $table) {
            $table->id(); 
            $table->string('projectID')->unique();
            $table->primary('projectID');
            $table->string('projectTitle');
            $table->string('projectLoc');
            $table->string('projectContractor');
            $table->string('sourceOfFunds');
            $table->string('otherFund')->nullable(); 
            $table->string('modeOfImplementation');
            $table->text('projectDescription');
            $table->string('projectContractDays');
            $table->date('officialStart')->nullable();
            $table->date('targetCompletion')->nullable();
            $table->string('timeExtension')->nullable();
            $table->string('revisedTargetCompletion')->nullable();
            $table->string('completionDate')->nullable();
            $table->string('abc', 15, 2)->nullable();
            $table->string('contractAmount', 15, 2)->nullable();
            $table->string('engineering', 15, 2)->nullable();
            $table->string('mqc', 15, 2)->nullable();
            $table->string('contingency', 15, 2)->nullable();
            $table->string('bid', 15, 2)->nullable();
            $table->string('appropriation', 15, 2)->nullable();
            $table->string('directOrIndirectCost', 15, 2)->nullable();
            $table->string('revisedContractCost', 15, 2)->nullable();
            $table->date('originalExpiryDate')->nullable();
            $table->date('revisedExpiryDate')->nullable();
            $table->date('noaIssuedDate')->nullable();
            $table->date('noaReceivedDate')->nullable();
            $table->date('ntpIssuedDate')->nullable();
            $table->date('ntpReceivedDate')->nullable();
            $table->string('projectSlippage')->nullable();
            $table->string('totalExpenditure')->nullable();
            $table->string('ea')->nullable();
            $table->string('contractCost')->nullable();
            $table->string('is_hidden')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('projects_tbl');
    }
};
