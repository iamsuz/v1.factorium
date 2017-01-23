<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddsLoginSiteColumnToRegistrationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->string('registration_site')->default('estatebaron.com');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_registrations', function (Blueprint $table) {
            $table->dropColumn('registration_site');
        });
    }
}
