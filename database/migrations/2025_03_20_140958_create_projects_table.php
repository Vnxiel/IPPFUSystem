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
            $table->date('noticeToProceed')->nullable();
            $table->date('officialStart')->nullable();
            $table->date('targetCompletion')->nullable();
            $table->date('suspensionOrderNo')->nullable();
            $table->date('resumeOrderNo')->nullable();
            $table->string('timeExtension')->default(0);
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
            $table->string('revisedContract', 15, 2)->nullable();
            $table->string('expenditure', 15, 2)->nullable();
            $table->date('originalExpiry')->nullable();
            $table->date('revisedExpiry')->nullable();
            $table->date('noticeOfAward')->nullable();
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
