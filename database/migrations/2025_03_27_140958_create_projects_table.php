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
            $table->string('projectTitle');
            $table->string('projectLoc');
            $table->string('projectContractor');
            $table->string('sourceOfFunds');
            $table->string('otherFund')->nullable(); 
            $table->string('modeOfImplementation');
            $table->string('projectStatus');
            $table->string('ongoingStatus')->nullable();
            $table->text('projectDescription');
            $table->string('projectContractDays');
            $table->string('noticeToProceed')->nullable();
            $table->string('officialStart')->nullable();
            $table->string('targetCompletion')->nullable();
            $table->string('suspensionOrderNo')->nullable();
            $table->string('resumeOrderNo')->nullable();
            $table->string('timeExtension')->default(0);
            $table->string('revisedTargetCompletion')->nullable();
            $table->date('completionDate')->nullable();
            $table->decimal('abc', 15, 2)->nullable();
            $table->decimal('contractAmount', 15, 2)->nullable();
            $table->decimal('engineering', 15, 2)->nullable();
            $table->decimal('mqc', 15, 2)->nullable();
            $table->decimal('contingency', 15, 2)->nullable();
            $table->decimal('bidDifference', 15, 2)->nullable();
            $table->decimal('appropriation', 15, 2)->nullable();
            $table->decimal('directOrIndirectCost', 15, 2)->nullable();
            $table->decimal('revisedContract', 15, 2)->nullable();
            $table->decimal('expenditure', 15, 2)->nullable();
            $table->date('originalExpiry')->nullable();
            $table->date('revisedExpiry')->nullable();
            $table->date('awardDate')->nullable();
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
