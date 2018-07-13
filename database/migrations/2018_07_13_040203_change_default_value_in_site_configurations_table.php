<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDefaultValueInSiteConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function (Blueprint $table) {
            $table->string('afsl_no')->default('275444')->nullable()->change();
            $table->string('car_no')->default('001264952')->nullable()->change();
            $table->string('terms_conditions_link')->default('NULL')->nullable()->change();
            $table->string('privacy_link')->default('NULL')->nullable()->change();
            $table->string('financial_service_guide_link')->default('NULL')->nullable()->change();
            $table->string('licensee_name')->default('AusFirst Compliance Partners Limited')->nullable()->change();
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
            $table->string('afsl_no')->default('299812')->nullable()->change();
            $table->string('car_no')->default('001251881')->nullable()->change();
            $table->string('terms_conditions_link')->default('https://whitelabel.estatebaron.com/terms_conditions_link')->nullable()->change();
            $table->string('privacy_link')->default('https://whitelabel.estatebaron.com/privacy_link')->nullable()->change();
            $table->string('financial_service_guide_link')->default('https://whitelabel.estatebaron.com/financial_service_guide_link')->nullable()->change();
            $table->string('licensee_name')->default('Ricard Securities')->nullable()->change();
        });
    }
}
