<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsColumnRegistrationRequestFillingHelpProjectIdToRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_registrations',function (Blueprint $table)
        {
            $table->string('request_form_project_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_registrations',function (Blueprint $table)
        {
            $table->dropColumn('request_form_project_id');
        });
    }
}
