<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCryptoExchangeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_exchange_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('source_token', 5);
            $table->double('source_token_amount', 20,2);
            $table->string('dest_token', 5);
            $table->double('dest_token_amount', 20,2)->nullable();
            $table->string('transaction_hash', 100)->nullable();
            $table->longText('transaction_response1')->nullable();
            $table->longText('transaction_response2')->nullable();
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
        Schema::drop('crypto_exchange_transactions');
    }
}
