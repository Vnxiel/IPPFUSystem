<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('projectID')->unique(); // External/public identifier

            $table->string('projectTitle');
            $table->string('projectLoc');
            $table->string('projectContractor');
            $table->string('sourceOfFunds');
            $table->string('otherFund')->nullable();
            $table->string('modeOfImplementation');
            $table->string('projectContractDays');

            $table->date('officialStart')->nullable();
            $table->date('targetCompletion')->nullable();
            $table->string('timeExtension')->nullable();
            $table->string('revisedTargetCompletion')->nullable();
            $table->string('completionDate')->nullable();

           
            $table->string('abc')->nullable();
            $table->string('contractAmount')->nullable();
            $table->string('engineering')->nullable();
            $table->string('mqc')->nullable();
            $table->string('contingency')->nullable();
            $table->string('bid')->nullable();
            $table->string('appropriation')->nullable();
            $table->string('directOrIndirectCost')->nullable();
            $table->string('revisedContractCost')->nullable();

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
            $table->string('otherContractor')->nullable();
            $table->boolean('is_hidden')->default(false); // Better as boolean

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
