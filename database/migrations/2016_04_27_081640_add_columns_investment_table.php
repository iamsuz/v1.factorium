<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInvestmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->text('bank')->nullable();
            $table->text('bank_account_name')->nullable();
            $table->text('bsb')->nullable();
            $table->text('bank_account_number')->nullable();
            $table->text('bank_reference')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dropColumn('bank');
            $table->dropColumn('bank_account_name');
            $table->dropColumn('bsb');
            $table->dropColumn('bank_account_number');
            $table->dropColumn('bank_reference');
        });
    }
}
