<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAudkDefaultProjectToSiteConfigurationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('site_configurations', function($table) {
            $table->integer('audk_default_project_id')->unsigned()->nullable();
            $table->foreign('audk_default_project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('site_configurations', function($table) {
            $table->dropColumn('audk_default_project_id');
        });
    }
}
