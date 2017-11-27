<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSiteConfigurations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            $table->string('licensee_name')->default('Ricard Securities')->nullable();
            $table->string('afsl_no')->default('299812')->nullable();
            $table->string('car_no')->default('001251881')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            $table->dropColumn('licensee_name');
            $table->dropColumn('afsl_no');
            $table->dropColumn('car_no');
        });
    }
}
