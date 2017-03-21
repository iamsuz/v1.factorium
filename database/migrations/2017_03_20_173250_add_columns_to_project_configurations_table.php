<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_configurations', function (Blueprint $table) {
            if (!Schema::hasColumn('project_configurations', 'overlay_opacity')) {
                $table->decimal('overlay_opacity', 1, 1)->default(0.6);
            }
            if (!Schema::hasColumn('project_configurations', 'show_summary_section')) {
                $table->boolean('show_summary_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_project_security_section')) {
                $table->boolean('show_project_security_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_investor_distribution_section')) {
                $table->boolean('show_investor_distribution_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_marketability_section')) {
                $table->boolean('show_marketability_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_residents_section')) {
                $table->boolean('show_residents_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_investment_type_section')) {
                $table->boolean('show_investment_type_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_investment_security_section')) {
                $table->boolean('show_investment_security_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_expected_return_section')) {
                $table->boolean('show_expected_return_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_return_paid_as_section')) {
                $table->boolean('show_return_paid_as_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_taxation_section')) {
                $table->boolean('show_taxation_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_developer_section')) {
                $table->boolean('show_developer_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_duration_section')) {
                $table->boolean('show_duration_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_current_status_section')) {
                $table->boolean('show_current_status_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_rationale_section')) {
                $table->boolean('show_rationale_section')->default(1);
            }
            if (!Schema::hasColumn('project_configurations', 'show_risk_section')) {
                $table->boolean('show_risk_section')->default(1);
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_configurations', function (Blueprint $table) {
            if (Schema::hasColumn('project_configurations', 'overlay_opacity')) {
                $table->dropColumn('overlay_opacity');
            }
            if (Schema::hasColumn('project_configurations', 'show_summary_section')) {
                $table->boolean('show_summary_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_project_security_section')) {
                $table->boolean('show_project_security_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_investor_distribution_section')) {
                $table->boolean('show_investor_distribution_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_marketability_section')) {
                $table->boolean('show_marketability_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_residents_section')) {
                $table->boolean('show_residents_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_investment_type_section')) {
                $table->boolean('show_investment_type_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_investment_security_section')) {
                $table->boolean('show_investment_security_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_expected_return_section')) {
                $table->boolean('show_expected_return_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_return_paid_as_section')) {
                $table->boolean('show_return_paid_as_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_taxation_section')) {
                $table->boolean('show_taxation_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_developer_section')) {
                $table->boolean('show_developer_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_duration_section')) {
                $table->boolean('show_duration_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_current_status_section')) {
                $table->boolean('show_current_status_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_rationale_section')) {
                $table->boolean('show_rationale_section');
            }
            if (Schema::hasColumn('project_configurations', 'show_risk_section')) {
                $table->boolean('show_risk_section');
            }
        });
    }
}
