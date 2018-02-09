<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnProjectSiteToProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('investments', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('investment_investor', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('media', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('project_faqs', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('project_progs', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('project_user', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('site_configurations', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('id_images', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('documents', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->string('project_site')->default('https://estatebaron.com');
        });
        Schema::table('colors', function (Blueprint $table) {
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
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('investment_investor', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('locations', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('media', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('project_faqs', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('project_progs', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('project_user', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('site_configurations', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('id_images', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('comments', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
        Schema::table('colors', function (Blueprint $table) {
            $table->dropColumn('project_site');
        });
    }
}
