<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToProjectProgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_progs', function (Blueprint $table) {
            if (!Schema::hasColumn('project_progs', 'image_path')) {
                $table->string('image_path')->nullable();
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
        Schema::table('project_progs', function (Blueprint $table) {
            if (Schema::hasColumn('project_progs', 'image_path')) {
                $table->dropColumn('image_path');
            }
        });
    }
}
