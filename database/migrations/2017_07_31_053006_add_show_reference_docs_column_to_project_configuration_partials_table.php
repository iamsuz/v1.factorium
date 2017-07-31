<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowReferenceDocsColumnToProjectConfigurationPartialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_configuration_partials', function (Blueprint $table) {
                if (!Schema::hasColumn('project_configuration_partials', 'show_reference_docs')) {
                $table->boolean('show_reference_docs')->default(1);
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
        Schema::table('project_configuration_partials', function (Blueprint $table) {
                if (Schema::hasColumn('project_configuration_partials', 'show_reference_docs')) {
                $table->dropColumn('show_reference_docs');
            }
        });
    }
}
