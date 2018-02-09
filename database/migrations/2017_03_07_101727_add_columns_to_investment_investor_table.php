<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToInvestmentInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_investor', function (Blueprint $table) {
            if (!Schema::hasColumn('investment_investor', 'money_received')) {
                $table->boolean('money_received')->default(false);
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
        Schema::table('investment_investor', function (Blueprint $table) {
            if (Schema::hasColumn('investment_investor', 'money_received')) {
                $table->dropColumn('money_received');
            }
        });
    }
}
