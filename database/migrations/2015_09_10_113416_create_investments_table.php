<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->double('goal_amount',20,2);
            $table->double('minimum_accepted_amount',10,2);
            $table->double('maximum_accepted_amount',20,2);
            $table->double('total_projected_costs',20,2);
            $table->double('total_debt',20,2);
            $table->double('total_equity',20,2);
            $table->double('developer_equity',20,2);
            $table->string('projected_returns');
            $table->string('hold_period');
            $table->string('annual_cash_yield');
            $table->text('proposer')->nullable(); //developer
            $table->text('summary')->nullable();
            $table->text('security_long')->nullable();
            $table->text('rationale')->nullable();
            $table->text('current_status')->nullable();
            $table->text('exit_d')->nullable();
            $table->text('investment_type')->nullable();
            $table->text('security')->nullable();
            $table->text('expected_returns_long')->nullable();
            $table->text('returns_paid_as')->nullable();
            $table->text('taxation')->nullable();
            $table->text('marketability')->nullable();
            $table->text('residents')->nullable();
            $table->text('plans_permit_url')->nullable();
            $table->text('construction_contract_url')->nullable();
            $table->text('consultancy_agency_agreement_url')->nullable();
            $table->text('debt_details_url')->nullable();
            $table->text('master_pds_url')->nullable();
            $table->text('caveats_url')->nullable();
            $table->text('land_ownership_url')->nullable();
            $table->text('valuation_report_url')->nullable();
            $table->text('consent_url')->nullable();
            $table->text('spv_url')->nullable();
            $table->text('investments_structure_image_url')->nullable();
            $table->text('investments_structure_video_url')->nullable();
            $table->text('risk')->nullable();
            $table->text('how_to_invest')->nullable();
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
        Schema::drop('investments');
    }
}
