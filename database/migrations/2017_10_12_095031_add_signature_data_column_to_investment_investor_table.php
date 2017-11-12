<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSignatureDataColumnToInvestmentInvestorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_investor', function (Blueprint $table) {
            if (!Schema::hasColumn('investment_investor', 'signature_data')) {
                $table->longText('signature_data')->nullable();
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
            if (Schema::hasColumn('investment_investor', 'signature_data')) {
                $table->dropColumn('signature_data');
            }
        });
    }
}
