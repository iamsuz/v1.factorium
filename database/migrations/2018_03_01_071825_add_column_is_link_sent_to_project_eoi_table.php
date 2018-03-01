<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnIsLinkSentToProjectEoiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_eoi', function (Blueprint $table) {
            if (!Schema::hasColumn('project_eoi', 'is_link_sent')) {
                $table->boolean('is_link_sent');
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
        Schema::table('project_eoi', function (Blueprint $table) {
            if (Schema::hasColumn('project_eoi', 'is_link_sent')) {
                $table->dropColumn('is_link_sent');
            }
        });
    }
}
