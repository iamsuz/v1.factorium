<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_configurations', function (Blueprint $table) {
            if (!Schema::hasColumn('project_configurations', 'overlay_opacity')) {
                $table->decimal('overlay_opacity', 1, 1)->default(0.6);
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
        Schema::table('project_configurations', function (Blueprint $table) {
            if (Schema::hasColumn('project_configurations', 'overlay_opacity')) {
                $table->dropColumn('overlay_opacity');
            }
        });
    }
}
