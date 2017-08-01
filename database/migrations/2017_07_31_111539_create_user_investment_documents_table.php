<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserInvestmentDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_investment_documents', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('investment_investor_id')->unsigned();
            $table->foreign('investment_investor_id')->references('id')->on('investment_investor');
            $table->integer('investing_joint_id')->unsigned();
            $table->foreign('investing_joint_id')->references('id')->on('investing_joint');
            $table->string('filename');
            $table->string('type');
            $table->string('path');
            $table->string('extension');
            $table->boolean('verified')->default(0);
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
        Schema::drop('users_investment_documents');
    }
}
