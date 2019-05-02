<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnInvestmentForCompletionInInvestmentInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_investor', function($table) {
            $table->boolean('investment_completion');
            $table->integer('pay_investment_id')->unsigned()->nullable();
            $table->foreign('pay_investment_id')->references('id')->on('investment_investor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investment_investor', function($table) {
            $table->dropColumn('investment_completion');
            $table->dropColumn('pay_investment_id');
        });
    }
}
