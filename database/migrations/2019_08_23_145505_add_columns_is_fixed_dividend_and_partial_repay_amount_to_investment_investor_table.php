<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsIsFixedDividendAndPartialRepayAmountToInvestmentInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_investor', function (Blueprint $table) {
            $table->boolean('is_partial_repay')->default(0);
            $table->double('partial_repay_amount', 20,2)->nullable();
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
            $table->dropColumn('is_partial_repay');
            $table->dropColumn('partial_repay_amount');
        });
    }
}
