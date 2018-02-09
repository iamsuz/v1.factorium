<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectConfigurationPartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('project_configuration_partials')) {
            Schema::create('project_configuration_partials', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('project_id')->unsigned();
                $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
                $table->decimal('overlay_opacity', 1, 1)->default(0.6);
                $table->boolean('show_summary_section')->default(1);
                $table->boolean('show_project_security_section')->default(1);
                $table->boolean('show_investor_distribution_section')->default(1);
                $table->boolean('show_marketability_section')->default(1);
                $table->boolean('show_residents_section')->default(1);
                $table->boolean('show_investment_type_section')->default(1);
                $table->boolean('show_investment_security_section')->default(1);
                $table->boolean('show_expected_return_section')->default(1);
                $table->boolean('show_return_paid_as_section')->default(1);
                $table->boolean('show_taxation_section')->default(1);
                $table->boolean('show_developer_section')->default(1);
                $table->boolean('show_duration_section')->default(1);
                $table->boolean('show_current_status_section')->default(1);
                $table->boolean('show_rationale_section')->default(1);
                $table->boolean('show_risk_section')->default(1);
                $table->boolean('show_prospectus_text')->default(1);
                $table->boolean('show_project_progress')->default(1);
                $table->boolean('show_project_progress_circle')->default(1);
                $table->boolean('show_project_thumbnail_on_home')->default(1);
                $table->string('expected_return_label_text')->default('Expected Return');
                $table->boolean('show_project_summary_whole_section')->default(1);
                $table->boolean('show_suburb_whole_section')->default(1);
                $table->boolean('show_investment_whole_section')->default(1);
                $table->boolean('show_project_profile_whole_section')->default(1);
                $table->boolean('show_how_to_invest_whole_section')->default(1);
                $table->boolean('show_project_faqs_whole_section')->default(1);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project_configuration_partials');
    }
}
