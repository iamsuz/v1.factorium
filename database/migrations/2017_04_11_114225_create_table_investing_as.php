<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInvestingAs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investing_joint', function(Blueprint $table)
        {
            $table->increments('id');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('investment_investor_id')->unsigned();
            $table->foreign('investment_investor_id')->references('id')->on('investment_investor');
            $table->string('joint_investor_first_name')->nullable();
            $table->string('joint_investor_last_name')->nullable();
            $table->string('investing_company')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('investing_joint');
    }
}
