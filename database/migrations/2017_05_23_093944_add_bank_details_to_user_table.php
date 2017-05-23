<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBankDetailsToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('bank_name')->nullable();
            $table->string('withdraw_account_name')->nullable();
            $table->string('withdraw_bsb')->nullable();
            $table->string('withdraw_account_number')->nullable();
            $table->string('withdraw_bank_name')->nullable();
            $table->string('tfn')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('bank_name');
            $table->dropColumn('withdraw_account_name');
            $table->dropColumn('withdraw_bsb');
            $table->dropColumn('withdraw_account_number');
            $table->dropColumn('withdraw_bank_name');
            $table->dropColumn('tfn');
        });
    }
}
