<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectSiteColumnToAboutUsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aboutus', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('credits', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('invites', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aboutus', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('invites', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
    }
}
