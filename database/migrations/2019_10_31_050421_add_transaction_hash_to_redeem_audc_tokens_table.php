<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTransactionHashToRedeemAudcTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('redeem_audc_tokens', function (Blueprint $table) {
            $table->string('transaction_hash', 100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('redeem_audc_tokens', function (Blueprint $table) {
            $table->dropColumn('transaction_hash');
        });
    }
}
