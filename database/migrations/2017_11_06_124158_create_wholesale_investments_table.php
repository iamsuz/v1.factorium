<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWholesaleInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wholesale_investments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('investment_investor_id')->unsigned();
            $table->foreign('investment_investor_id')->references('id')->on('investment_investor');
            $table->string('wholesale_investing_as')->nullable();
            $table->string('accountant_name_and_firm')->nullable();
            $table->string('accountant_professional_body_designation')->nullable();
            $table->string('accountant_email')->nullable();
            $table->string('accountant_phone')->nullable();
            $table->text('equity_investment_experience_text')->nullable();
            $table->string('experience_period')->nullable();
            $table->text('unlisted_investment_experience_text')->nullable();
            $table->text('understand_risk_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('wholesale_investments');
    }
}
