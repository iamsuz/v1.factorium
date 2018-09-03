<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowDurationAndShowExpectedReturnToProjectConfigurationPartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_configuration_partials', function (Blueprint $table) {
            $table->boolean('show_duration')->default(1);
            $table->boolean('show_expected_return')->default(1);
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
            $table->dropColumn('show_duration');
            $table->dropColumn('show_expected_return');
        });
    }
}
