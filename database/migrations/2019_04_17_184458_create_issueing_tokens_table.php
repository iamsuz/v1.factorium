<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueingTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issueing_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('project_id')->unsigned();
            $table->foreign('project_id')->references('id')->on('projects');
            $table->integer('investment_investor_id')->unsigned();
            $table->foreign('investment_investor_id')->references('id')->on('investment_investor');
            $table->string('transaction_type')->nullable();
            $table->dateTime('transaction_date')->nullable();
            $table->double('amount', 20,2);
            $table->double('rate', 10,2);
            $table->integer('number_of_shares')->unsigned();
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
        Schema::drop('issueing_tokens');
    }
}
