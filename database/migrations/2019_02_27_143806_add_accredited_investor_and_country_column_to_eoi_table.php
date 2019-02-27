<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAccreditedInvestorAndCountryColumnToEoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_eoi', function (Blueprint $table) {
            $table->boolean('is_accredited_investor')->default(1);
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_eoi', function (Blueprint $table) {
            $table->dropColumn('is_accredited_investor');
            $table->dropColumn('country');
            $table->dropColumn('country_code');
        });
    }
}
