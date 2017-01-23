<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddButtonFieldColumnToProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        if (!Schema::hasColumn('projects', 'button_label')) {
            Schema::table('projects', function ($table) {
                $table->string('button_label')->nullable();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function ($table) {
            $table->dropColumn('button_label');
        });

    }
}
