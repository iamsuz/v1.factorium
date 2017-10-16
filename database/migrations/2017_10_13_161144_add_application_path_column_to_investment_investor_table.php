<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApplicationPathColumnToInvestmentInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_investor', function (Blueprint $table) {
            if (!Schema::hasColumn('investment_investor', 'application_path')) {
                $table->string('application_path')->nullable();
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
            if (Schema::hasColumn('investment_investor', 'application_path')) {
                $table->dropColumn('application_path');
            }
        });
    }
}
