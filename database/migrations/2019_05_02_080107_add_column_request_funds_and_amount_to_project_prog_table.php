<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnRequestFundsAndAmountToProjectProgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_progs', function($table) {
            $table->string('request_funds')->nullable();
            $table->integer('amount');
            $table->boolean('is_voting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_progs', function($table) {
            $table->dropColumn('request_funds');
            $table->dropColumn('amount');
            $table->dropColumn('is_voting');
        });
    }
}
