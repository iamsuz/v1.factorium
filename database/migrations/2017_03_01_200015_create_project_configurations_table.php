<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_configurations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->string('project_summary_label')->default('Project Summary');
            $table->string('summary_label')->default('Summary');
            $table->string('security_label')->default('Security');
            $table->string('investor_distribution_label')->default('Investor Distribution');
            $table->string('suburb_profile_label')->default('Suburb Profile');
            $table->string('marketability_label')->default('Marketability');
            $table->string('residents_label')->default('Residents');
            $table->string('investment_profile_label')->default('Investment Profile');
            $table->string('investment_type_label')->default('Type');
            $table->string('investment_security_label')->default('Security');
            $table->string('expected_returns_label')->default('Expected Returns');
            $table->string('return_paid_as_label')->default('Return Paid As');
            $table->string('taxation_label')->default('Taxation');
            $table->string('project_profile_label')->default('Project Profile');
            $table->string('developer_label')->default('Developer');
            $table->string('venture_label')->default('Venture');
            $table->string('duration_label')->default('Duration');
            $table->string('current_status_label')->default('Current Status');
            $table->string('rationale_label')->default('Rationale');
            $table->string('investment_risk_label')->default('Risk');
            $table->boolean('show_suburb_profile_map')->default(true);
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
        Schema::drop('project_configurations');
    }
}
