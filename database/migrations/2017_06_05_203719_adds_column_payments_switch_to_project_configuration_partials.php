<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsColumnPaymentsSwitchToProjectConfigurationPartials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_configuration_partials', function (Blueprint $table) {
                $table->boolean('payment_switch')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_configuration_partials', function(Blueprint $table) {
            $table->dropColumn('payment_switch');
        });
    }
}
