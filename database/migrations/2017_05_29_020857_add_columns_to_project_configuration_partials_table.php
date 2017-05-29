<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectConfigurationPartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_configuration_partials', function (Blueprint $table) {
            if (!Schema::hasColumn('project_configuration_partials', 'show_project_investor_count')) {
                $table->boolean('show_project_investor_count')->default(1);
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
        Schema::table('project_configuration_partials', function (Blueprint $table) {
            if (Schema::hasColumn('project_configuration_partials', 'show_project_investor_count')) {
                $table->dropColumn('show_project_investor_count');
            }
        });
    }
}
