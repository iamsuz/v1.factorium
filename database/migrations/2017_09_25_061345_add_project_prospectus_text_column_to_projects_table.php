<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProjectProspectusTextColumnToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
                if (!Schema::hasColumn('projects', 'project_prospectus_text')) {
                $table->string('project_prospectus_text')->nullable();
            }
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
                if (Schema::hasColumn('projects', 'project_prospectus_text')) {
                $table->dropColumn('project_prospectus_text');
            }
        });
    }
}
